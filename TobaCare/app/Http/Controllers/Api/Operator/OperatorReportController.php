<?php

namespace App\Http\Controllers\Api\Operator;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Report;
use App\Models\ResolutionEvidence;
use App\Services\AuditLogger;
use App\Services\NotificationService;
use App\Support\ReportTransitions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OperatorReportController extends Controller
{
    public function __construct(
        protected AuditLogger $auditLogger,
        protected NotificationService $notificationService
    ) {}

    /**
     * GET /api/v1/operator/reports - List tasks assigned to the authenticated operator.
     */
    public function index(Request $request): JsonResponse
    {
        $operator = $request->user();

        $query = Report::query()
            ->whereHas('assignments', function ($q) use ($operator) {
                $q->where('operator_id', $operator->id)
                  ->where('is_active', true);
            })
            ->with([
                'location',
                'category',
                'images',
                'activeAssignment.assignedBy',
            ]);

        // Status filter: assigned, in_progress, resolved
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        // Priority filter
        if ($priority = $request->query('priority')) {
            $query->where('priority_final', $priority);
        }

        // Search query
        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        $reports = $query->orderByRaw("
            CASE priority_final 
                WHEN 'critical' THEN 1 
                WHEN 'high' THEN 2 
                WHEN 'medium' THEN 3 
                ELSE 4 
            END
        ")->latest('created_at')->paginate($request->integer('per_page', 15));

        return response()->json([
            'data' => $reports->items(),
            'meta' => [
                'current_page' => $reports->currentPage(),
                'last_page'    => $reports->lastPage(),
                'per_page'     => $reports->perPage(),
                'total'        => $reports->total(),
            ],
            'stats' => [
                'total_assigned' => Report::whereHas('assignments', fn ($q) => $q->where('operator_id', $operator->id)->where('is_active', true))->where('status', 'assigned')->count(),
                'in_progress'    => Report::whereHas('assignments', fn ($q) => $q->where('operator_id', $operator->id)->where('is_active', true))->where('status', 'in_progress')->count(),
                'resolved'       => Report::whereHas('assignments', fn ($q) => $q->where('operator_id', $operator->id)->where('is_active', true))->where('status', 'resolved')->count(),
            ],
        ]);
    }

    /**
     * GET /api/v1/operator/reports/{id} - View detail of assigned report.
     */
    public function show(Request $request, string $id): JsonResponse
    {
        $operator = $request->user();

        $report = Report::query()
            ->whereHas('assignments', function ($q) use ($operator) {
                $q->where('operator_id', $operator->id)
                  ->where('is_active', true);
            })
            ->with([
                'location',
                'category',
                'images',
                'activeAssignment.assignedBy',
                'activeAssignment.agency',
                'statusHistory.user',
                'resolutionEvidences.uploader',
                'user:id,name',
            ])
            ->findOrFail($id);

        return response()->json(['report' => $report]);
    }

    /**
     * POST /api/v1/operator/reports/{id}/start - Operator accepts and starts work (assigned -> in_progress).
     */
    public function startProgress(Request $request, string $id): JsonResponse
    {
        $operator = $request->user();

        $report = Report::query()
            ->whereHas('assignments', function ($q) use ($operator) {
                $q->where('operator_id', $operator->id)
                  ->where('is_active', true);
            })
            ->with('activeAssignment')
            ->findOrFail($id);

        if ($report->status !== 'assigned') {
            throw new ApiException(
                'STATUS_CONFLICT',
                "Laporan tidak dalam status 'assigned' (status saat ini: {$report->status}).",
                409
            );
        }

        if (! ReportTransitions::allowed($report->status, 'in_progress')) {
            throw new ApiException('INVALID_STATE_TRANSITION', 'Transisi status tidak diizinkan.', 409);
        }

        DB::transaction(function () use ($report, $operator, $request) {
            $report->transitionTo('in_progress', $operator->id, 'Operator memulai pengerjaan di lapangan.');

            if ($report->activeAssignment && ! $report->activeAssignment->accepted_at) {
                $report->activeAssignment->update(['accepted_at' => now()]);
            }

            $this->auditLogger->log(
                $operator,
                'report.start_progress',
                'report',
                $report->id,
                ['status' => 'assigned'],
                ['status' => 'in_progress'],
                $request->ip()
            );

            // Notify citizen
            $this->notificationService->notify(
                $report->user_id,
                $report->id,
                'status_changed',
                "Laporan Anda '#{$report->title}' kini sedang ditangani oleh petugas lapangan ({$operator->name}).",
                $operator->id
            );
        });

        return response()->json([
            'message' => 'Status laporan berhasil diperbarui ke sedang dikerjakan (in_progress).',
            'report'  => $report->fresh(['location', 'category', 'images', 'activeAssignment']),
        ]);
    }

    /**
     * POST /api/v1/operator/reports/{id}/resolve - Operator completes work (in_progress -> resolved).
     */
    public function resolve(Request $request, string $id): JsonResponse
    {
        $operator = $request->user();

        $data = $request->validate([
            'note'           => ['required', 'string', 'min:5', 'max:500'],
            'evidence_image' => ['nullable', 'file', 'image', 'mimes:jpeg,png,webp,jpg', 'max:5120'],
            'file'           => ['nullable', 'file', 'image', 'mimes:jpeg,png,webp,jpg', 'max:5120'],
        ], [
            'note.required'        => 'Catatan penyelesaian pekerjaan wajib diisi.',
            'note.min'             => 'Catatan penyelesaian minimal 5 karakter.',
            'evidence_image.image' => 'Bukti penyelesaian harus berupa berkas gambar.',
            'evidence_image.max'   => 'Ukuran foto bukti tidak boleh melebihi 5 MB.',
            'file.image'           => 'Bukti penyelesaian harus berupa berkas gambar.',
            'file.max'             => 'Ukuran foto bukti tidak boleh melebihi 5 MB.',
        ]);

        $report = Report::query()
            ->whereHas('assignments', function ($q) use ($operator) {
                $q->where('operator_id', $operator->id)
                  ->where('is_active', true);
            })
            ->with('activeAssignment')
            ->findOrFail($id);

        if ($report->status !== 'in_progress') {
            throw new ApiException(
                'STATUS_CONFLICT',
                "Laporan belum berstatus 'in_progress' (status saat ini: {$report->status}). Silakan mulai pengerjaan terlebih dahulu.",
                409
            );
        }

        if (! ReportTransitions::allowed($report->status, 'resolved')) {
            throw new ApiException('INVALID_STATE_TRANSITION', 'Transisi status tidak diizinkan.', 409);
        }

        DB::transaction(function () use ($report, $operator, $data, $request) {
            $report->transitionTo('resolved', $operator->id, $data['note'], [
                'resolved_at' => now(),
            ]);

            // Save evidence image if uploaded
            $uploadedFile = $request->file('evidence_image') ?? $request->file('file');
            if ($uploadedFile) {
                $path = $uploadedFile->store('evidences/' . date('Y/m'), 'public');
                ResolutionEvidence::create([
                    'report_id'     => $report->id,
                    'assignment_id' => $report->activeAssignment?->id,
                    'uploaded_by'   => $operator->id,
                    'storage_key'   => $path,
                    'mime_type'     => $uploadedFile->getMimeType(),
                    'size_bytes'    => $uploadedFile->getSize(),
                    'note'          => $data['note'],
                ]);
            }

            $this->auditLogger->log(
                $operator,
                'report.resolve',
                'report',
                $report->id,
                ['status' => 'in_progress'],
                ['status' => 'resolved', 'note' => $data['note'], 'has_evidence' => (bool) $uploadedFile],
                $request->ip()
            );

            // Notify citizen
            $this->notificationService->notify(
                $report->user_id,
                $report->id,
                'report_resolved',
                "Pekerjaan untuk laporan '#{$report->title}' telah diselesaikan: {$data['note']}.",
                $operator->id
            );
        });

        return response()->json([
            'message' => 'Laporan berhasil ditandai selesai (resolved).',
            'report'  => $report->fresh(['location', 'category', 'images', 'activeAssignment', 'resolutionEvidences.uploader']),
        ]);
    }

    /**
     * POST /api/v1/operator/reports/{id}/evidence - Upload additional resolution evidence photo.
     */
    public function uploadEvidence(Request $request, string $id): JsonResponse
    {
        $operator = $request->user();

        $request->validate([
            'file' => ['required', 'file', 'image', 'mimes:jpeg,png,webp,jpg', 'max:5120'],
            'note' => ['nullable', 'string', 'max:500'],
        ], [
            'file.required' => 'Berkas foto bukti wajib diunggah.',
            'file.image'    => 'Berkas harus berupa gambar.',
            'file.max'      => 'Ukuran foto bukti tidak boleh melebihi 5 MB.',
        ]);

        $report = Report::query()
            ->whereHas('assignments', function ($q) use ($operator) {
                $q->where('operator_id', $operator->id)
                  ->where('is_active', true);
            })
            ->with('activeAssignment')
            ->findOrFail($id);

        $file = $request->file('file');
        $path = $file->store('evidences/' . date('Y/m'), 'public');

        $evidence = ResolutionEvidence::create([
            'report_id'     => $report->id,
            'assignment_id' => $report->activeAssignment?->id,
            'uploaded_by'   => $operator->id,
            'storage_key'   => $path,
            'mime_type'     => $file->getMimeType(),
            'size_bytes'    => $file->getSize(),
            'note'          => $request->input('note') ? strip_tags($request->input('note')) : null,
        ]);

        $this->auditLogger->log(
            $operator,
            'report.upload_evidence',
            'report',
            $report->id,
            [],
            ['evidence_id' => $evidence->id],
            $request->ip()
        );

        return response()->json([
            'message'  => 'Foto bukti penyelesaian berhasil diunggah.',
            'evidence' => $evidence->fresh('uploader'),
        ], 201);
    }

}
