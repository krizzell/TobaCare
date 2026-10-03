<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminReportDetailResource;
use App\Http\Resources\AdminReportListResource;
use App\Models\Assignment;
use App\Models\Category;
use App\Models\Report;
use App\Models\User;
use App\Services\AiCorrectionService;
use App\Services\AuditLogger;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminReportController extends Controller
{
    /**
     * GET /admin/reports - Queue of reports with filters.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending_verification');
        $needsReview = $request->query('needs_manual_review');
        $categoryId = $request->query('category_id');
        $priority = $request->query('priority');
        $from = $request->query('from');
        $to = $request->query('to');
        $q = $request->query('q');
        $sort = $request->query('sort', 'newest');
        $perPage = min(50, max(1, (int) $request->query('per_page', 20)));

        $query = Report::query()->whereNull('merged_into_id');

        // Status filter
        if ($status !== 'all') {
            $statuses = array_filter(array_map('trim', explode(',', $status)));
            if (! empty($statuses)) {
                $query->whereIn('status', $statuses);
            }
        }

        // needs_manual_review filter
        if ($needsReview !== null && $needsReview !== '') {
            $boolVal = filter_var($needsReview, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($boolVal !== null) {
                $query->where('needs_manual_review', $boolVal);
            }
        }

        // category_id filter
        if ($categoryId !== null && $categoryId !== '') {
            $query->where('category_id', (int) $categoryId);
        }

        // priority filter
        if ($priority !== null && $priority !== '') {
            $query->where('priority_final', $priority);
        }

        // Date range filter
        if ($from || $to) {
            if ($from && $to && Carbon::parse($from)->gt(Carbon::parse($to))) {
                throw ValidationException::withMessages([
                    'from' => ['Tanggal from tidak boleh lebih besar dari to.'],
                ]);
            }
            if ($from) {
                $query->where('created_at', '>=', Carbon::parse($from)->startOfDay());
            }
            if ($to) {
                $query->where('created_at', '<=', Carbon::parse($to)->endOfDay());
            }
        }

        // Search query
        if ($q !== null && trim($q) !== '') {
            $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], trim($q));
            $query->where('title', 'ILIKE', "%{$escaped}%");
        }

        // Sorting
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Eager loading
        $query->with([
            'category',
            'location',
            'images',
            'analyses' => fn ($a) => $a->latest('started_at')->with([
                'classifications' => fn ($c) => $c->where('rank', 1),
            ]),
        ]);

        $paginator = $query->paginate($perPage);

        return response()->json([
            'items'    => AdminReportListResource::collection($paginator->items()),
            'page'     => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total'    => $paginator->total(),
        ]);
    }

    /**
     * GET /admin/reports/{id} - Full detail for AI review.
     */
    public function show(Request $request, string $id)
    {
        $report = Report::with([
            'user',
            'category',
            'location',
            'images',
            'statusHistory.changedByUser',
            'analyses.classifications',
            'currentPriorityRecommendation',
            'activeAssignment.operator',
            'activeAssignment.agency',
        ])->findOrFail($id);

        return response()->json(new AdminReportDetailResource($report));
    }

    /**
     * POST /reports/{id}/verify - Verify report.
     */
    public function verify(
        Request $request,
        string $id,
        AiCorrectionService $aiCorrection,
        AuditLogger $auditLogger,
        NotificationService $notificationService
    ) {
        $data = $request->validate([
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->where('is_active', true)],
            'priority'    => ['required', 'string', Rule::in(['low', 'medium', 'high', 'critical'])],
            'note'        => ['nullable', 'string', 'max:500'],
        ]);

        $admin = $request->user();
        $note = isset($data['note']) ? strip_tags($data['note']) : null;

        $result = DB::transaction(function () use ($id, $data, $note, $admin, $aiCorrection, $auditLogger, $notificationService, $request) {
            $report = Report::where('id', $id)->lockForUpdate()->firstOrFail();

            if ($report->merged_into_id !== null) {
                throw new ApiException('REPORT_MERGED', 'Laporan yang telah digabung tidak dapat diverifikasi', 409);
            }

            if ($report->status !== 'pending_verification') {
                throw new ApiException(
                    'INVALID_TRANSITION',
                    'Hanya laporan dengan status pending_verification yang dapat diverifikasi',
                    409,
                    ['from' => $report->status, 'to' => 'verified']
                );
            }

            $category = Category::findOrFail($data['category_id']);

            // Determine priority source and update priority recommendation if active
            $prioRec = $report->priorityRecommendations()->where('is_current', true)->first();
            $prioritySource = 'admin';
            if ($prioRec) {
                if ($prioRec->recommended_level === $data['priority']) {
                    $prioritySource = 'ai';
                }
                $prioRec->update([
                    'admin_final_level' => $data['priority'],
                    'decided_by'        => $admin->id,
                    'decided_at'        => now(),
                ]);
            }

            // Apply human confirmation / correction to AI classifications
            $aiCorrection->applyHumanLabel($report, $category->code, $admin, $note);

            $before = [
                'status'          => $report->status,
                'category_id'     => $report->category_id,
                'priority_final'  => $report->priority_final,
                'priority_source' => $report->priority_source,
            ];

            $report->transitionTo('verified', $admin->id, $note, [
                'category_id'         => $category->id,
                'priority_final'      => $data['priority'],
                'priority_source'     => $prioritySource,
                'verified_at'         => now(),
                'needs_manual_review' => false,
            ]);

            $after = [
                'status'              => 'verified',
                'category_id'         => $category->id,
                'priority_final'      => $data['priority'],
                'priority_source'     => $prioritySource,
                'verified_at'         => $report->verified_at?->toISOString(),
                'needs_manual_review' => false,
                'note'                => $note,
            ];

            $auditLogger->log($admin, 'report.verify', 'report', $report->id, $before, $after, $request->ip());

            $notificationService->notify(
                $report->user_id,
                $report->id,
                'report_verified',
                "Laporan \"{$report->title}\" telah diverifikasi.",
                $admin->id
            );

            return $report;
        });

        return response()->json([
            'report' => [
                'id'                  => $result->id,
                'status'              => $result->status,
                'category'            => [
                    'id'   => $result->category->id,
                    'code' => $result->category->code,
                    'name' => $result->category->name,
                ],
                'priority_final'      => $result->priority_final,
                'priority_source'     => $result->priority_source,
                'verified_at'         => $result->verified_at?->toISOString(),
                'needs_manual_review' => (bool) $result->needs_manual_review,
            ],
            'status' => 'verified',
        ]);
    }

    /**
     * POST /reports/{id}/reject - Reject report.
     */
    public function reject(
        Request $request,
        string $id,
        AuditLogger $auditLogger,
        NotificationService $notificationService
    ) {
        $data = $request->validate([
            'reason' => ['required', 'string', 'min:10', 'max:500'],
        ]);

        $admin = $request->user();
        $reason = strip_tags($data['reason']);

        $result = DB::transaction(function () use ($id, $reason, $admin, $auditLogger, $notificationService, $request) {
            $report = Report::where('id', $id)->lockForUpdate()->firstOrFail();

            if ($report->merged_into_id !== null) {
                throw new ApiException('REPORT_MERGED', 'Laporan yang telah digabung tidak dapat ditolak', 409);
            }

            if ($report->status !== 'pending_verification') {
                throw new ApiException(
                    'INVALID_TRANSITION',
                    'Hanya laporan dengan status pending_verification yang dapat ditolak',
                    409,
                    ['from' => $report->status, 'to' => 'rejected']
                );
            }

            $before = [
                'status'           => $report->status,
                'rejection_reason' => $report->rejection_reason,
            ];

            $report->transitionTo('rejected', $admin->id, $reason, [
                'rejection_reason' => $reason,
            ]);

            $after = [
                'status'           => 'rejected',
                'rejection_reason' => $reason,
            ];

            $auditLogger->log($admin, 'report.reject', 'report', $report->id, $before, $after, $request->ip());

            $notificationService->notify(
                $report->user_id,
                $report->id,
                'status_changed',
                "Laporan \"{$report->title}\" ditolak: {$reason}",
                $admin->id
            );

            return $report;
        });

        return response()->json([
            'report' => [
                'id'               => $result->id,
                'status'           => $result->status,
                'rejection_reason' => $result->rejection_reason,
            ],
        ]);
    }

    /**
     * POST /reports/{id}/analysis/correct - Correct AI classification.
     */
    public function correct(
        Request $request,
        string $id,
        AiCorrectionService $aiCorrection,
        AuditLogger $auditLogger
    ) {
        $data = $request->validate([
            'label'   => ['required', 'string', Rule::exists('categories', 'code')->where('is_active', true)],
            'subtype' => ['nullable', 'string', 'max:50'],
            'reason'  => ['nullable', 'string', 'max:500'],
        ]);

        $admin = $request->user();
        $reason = isset($data['reason']) ? strip_tags($data['reason']) : null;
        $subtype = isset($data['subtype']) ? strip_tags($data['subtype']) : null;

        $result = DB::transaction(function () use ($id, $data, $reason, $subtype, $admin, $aiCorrection, $auditLogger, $request) {
            $report = Report::where('id', $id)->lockForUpdate()->firstOrFail();

            if ($report->merged_into_id !== null) {
                throw new ApiException('REPORT_MERGED', 'Laporan yang telah digabung tidak dapat dikoreksi', 409);
            }

            $allowedStates = ['pending_verification', 'verified', 'assigned', 'in_progress'];
            if (! in_array($report->status, $allowedStates, true)) {
                throw new ApiException(
                    'INVALID_STATE',
                    "Koreksi AI tidak diizinkan pada status {$report->status}",
                    409
                );
            }

            $latestAnalysis = $report->analyses()->latest('started_at')->first();
            $originalLabels = $latestAnalysis
                ? $latestAnalysis->classifications()->where('rank', 1)->pluck('label')->all()
                : [];

            $changed = $aiCorrection->applyHumanLabel($report, $data['label'], $admin, $reason, $subtype);

            if (empty($changed)) {
                throw new ApiException(
                    'NO_AI_RESULT',
                    'Hasil analisis AI tidak ditemukan untuk laporan ini. Anda tetap dapat menetapkan kategori saat verifikasi.',
                    422
                );
            }

            $category = Category::where('code', $data['label'])->firstOrFail();
            $oldCatId = $report->category_id;
            $report->update(['category_id' => $category->id]);

            $before = [
                'category_id' => $oldCatId,
                'labels'      => $originalLabels,
            ];

            $after = [
                'category_id'     => $category->id,
                'corrected_label' => $data['label'],
                'reason'          => $reason,
            ];

            $auditLogger->log($admin, 'ai.correct', 'report', $report->id, $before, $after, $request->ip());

            return $changed;
        });

        return response()->json([
            'classification'  => $result[0],
            'classifications' => $result,
        ]);
    }

    /**
     * POST /reports/{id}/assign - Assign or re-assign report to operator/agency.
     */
    public function assign(
        Request $request,
        string $id,
        AuditLogger $auditLogger,
        NotificationService $notificationService
    ) {
        $data = $request->validate([
            'operator_id' => [
                'nullable',
                'uuid',
                Rule::exists('users', 'id')->where(fn ($q) => $q->where('role_id', 2)->where('is_active', true)),
            ],
            'agency_id' => [
                'nullable',
                'uuid',
                Rule::exists('agencies', 'id')->where('is_active', true),
            ],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
            'note'     => ['nullable', 'string', 'max:500'],
        ]);

        if (empty($data['operator_id']) && empty($data['agency_id'])) {
            throw ValidationException::withMessages([
                'operator_id' => ['Minimal salah satu dari operator_id atau agency_id wajib diisi.'],
            ]);
        }

        $admin = $request->user();
        $note = isset($data['note']) ? strip_tags($data['note']) : null;

        $assignment = DB::transaction(function () use ($id, $data, $note, $admin, $auditLogger, $notificationService, $request) {
            $report = Report::where('id', $id)->lockForUpdate()->firstOrFail();

            if ($report->merged_into_id !== null) {
                throw new ApiException('REPORT_MERGED', 'Laporan yang telah digabung tidak dapat ditugaskan', 409);
            }

            if (! in_array($report->status, ['verified', 'assigned'], true)) {
                throw new ApiException(
                    'INVALID_TRANSITION',
                    'Hanya laporan dengan status verified atau assigned yang dapat ditugaskan',
                    409,
                    ['from' => $report->status, 'to' => 'assigned']
                );
            }

            // Deactivate previous active assignment
            $oldAssignment = $report->assignments()->where('is_active', true)->first();
            if ($oldAssignment) {
                $oldAssignment->update(['is_active' => false]);
            }

            // Create new assignment
            $newAssignment = Assignment::create([
                'report_id'   => $report->id,
                'assigned_by' => $admin->id,
                'operator_id' => $data['operator_id'] ?? null,
                'agency_id'   => $data['agency_id'] ?? null,
                'due_date'    => $data['due_date'] ?? null,
                'note'        => $note,
                'is_active'   => true,
            ]);

            // Transition status if first assignment
            if ($report->status === 'verified') {
                $report->transitionTo('assigned', $admin->id, 'Ditugaskan ke operator/instansi');
            }

            $before = [
                'assignment' => $oldAssignment ? [
                    'id'          => $oldAssignment->id,
                    'operator_id' => $oldAssignment->operator_id,
                    'agency_id'   => $oldAssignment->agency_id,
                ] : null,
            ];

            $after = [
                'assignment_id' => $newAssignment->id,
                'operator_id'   => $newAssignment->operator_id,
                'agency_id'     => $newAssignment->agency_id,
                'due_date'      => $newAssignment->due_date?->format('Y-m-d'),
                'note'          => $note,
            ];

            $auditLogger->log($admin, 'report.assign', 'report', $report->id, $before, $after, $request->ip());

            // Notify reporter
            $notificationService->notify(
                $report->user_id,
                $report->id,
                'report_assigned',
                "Laporan \"{$report->title}\" telah diteruskan untuk ditindaklanjuti.",
                $admin->id
            );

            // Notify operator if assigned
            if (! empty($data['operator_id'])) {
                $notificationService->notify(
                    $data['operator_id'],
                    $report->id,
                    'report_assigned',
                    "Anda mendapat penugasan baru: \"{$report->title}\".",
                    $admin->id
                );
            }

            return $newAssignment->load(['operator', 'agency']);
        });

        return response()->json([
            'assignment' => [
                'id'          => $assignment->id,
                'report_id'   => $assignment->report_id,
                'operator'    => $assignment->operator ? [
                    'id'   => $assignment->operator->id,
                    'name' => $assignment->operator->name,
                ] : null,
                'agency'      => $assignment->agency ? [
                    'id'   => $assignment->agency->id,
                    'name' => $assignment->agency->name,
                ] : null,
                'due_date'    => $assignment->due_date?->format('Y-m-d'),
                'note'        => $assignment->note,
                'accepted_at' => $assignment->accepted_at?->toISOString(),
                'is_active'   => (bool) $assignment->is_active,
            ],
        ]);
    }

    /**
     * GET /admin/operators - List active operators for assignment dropdown.
     */
    public function operators(Request $request)
    {
        $operators = User::query()
            ->where('role_id', 2)
            ->where('is_active', true)
            ->with('agency')
            ->orderBy('name')
            ->get();

        $items = $operators->map(fn ($user) => [
            'id'     => $user->id,
            'name'   => $user->name,
            'email'  => $user->email,
            'agency' => $user->agency ? [
                'id'   => $user->agency->id,
                'name' => $user->agency->name,
            ] : null,
        ]);

        return response()->json(['items' => $items]);
    }
}
