<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportImage;
use App\Services\ReportAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function store(Request $request, ReportAnalysisService $ai)
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'min:5', 'max:100'],
            'description'      => ['required', 'string', 'min:20', 'max:1000'],
            'additional_info'  => ['nullable', 'string', 'max:500'],
            'category_id'      => ['required', 'integer', Rule::exists('categories', 'id')->where('is_active', true)],
            'event_time'       => ['nullable', 'date', 'before_or_equal:now', 'after_or_equal:-30 days'],
            'location.lat'     => ['required', 'numeric', 'between:-90,90'],
            'location.lng'     => ['required', 'numeric', 'between:-180,180'],
            'location.address' => ['nullable', 'string', 'max:255'],
            'image_ids'        => ['required', 'array', 'min:1', 'max:3'],
            'image_ids.*'      => ['uuid', 'distinct'],
        ]);

        $user = $request->user();

        $images = ReportImage::whereIn('id', $data['image_ids'])
            ->where('uploaded_by', $user->id)
            ->whereNull('report_id')
            ->get();

        if ($images->count() !== count($data['image_ids'])) {
            return response()->json(['error' => [
                'code' => 'INVALID_IMAGE_IDS',
                'message' => 'Foto tidak ditemukan atau sudah dipakai laporan lain',
            ]], 422);
        }

        $report = DB::transaction(function () use ($data, $user, $images) {
            $report = Report::create([
                'user_id'         => $user->id,
                'category_id'     => $data['category_id'],
                'title'           => strip_tags($data['title']),
                'description'     => strip_tags($data['description']),
                'additional_info' => isset($data['additional_info']) ? strip_tags($data['additional_info']) : null,
                'event_time'      => $data['event_time'] ?? now(),
                'status'          => 'submitted',
            ]);

            Location::create([
                'report_id'    => $report->id,
                'latitude'     => $data['location']['lat'],
                'longitude'    => $data['location']['lng'],
                'address_text' => $data['location']['address'] ?? null,
            ]);

            foreach ($images->values() as $i => $image) {
                $image->update(['report_id' => $report->id, 'sort_order' => $i]);
            }

            $report->statusHistory()->create([
                'from_status' => null, 'to_status' => 'submitted',
                'changed_by' => $user->id, 'note' => 'Laporan dikirim',
            ]);

            return $report;
        });

        // di luar transaksi: kegagalan AI tidak membatalkan laporan
        $ai->run($report->load(['images', 'category']));

        return response()->json([
            'report' => $report->fresh(['location', 'images', 'category', 'statusHistory']),
        ], 201);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $isPublicExplore = $request->boolean('public', false);

        $query = Report::query()->with([
            'location',
            'category',
            'images',
            'statusHistory',
            'activeAssignment.operator',
        ]);

        if ($isPublicExplore) {
            // Public explore reports (verified, assigned, in_progress, resolved)
            $query->whereIn('status', ['verified', 'assigned', 'in_progress', 'resolved']);
        } else {
            // Citizen's own submitted reports
            $query->where('user_id', $user->id);
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($category = $request->query('category_id')) {
            $query->where('category_id', $category);
        }

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        $reports = $query->latest('created_at')->paginate($request->integer('per_page', 10));

        // Mask citizen name for privacy per FR-13
        $items = collect($reports->items())->map(function ($r) use ($user, $isPublicExplore) {
            $arr = $r->toArray();
            if ($isPublicExplore && $r->user_id !== $user->id) {
                $arr['reporter_masked'] = 'Warga (Disamarkan)';
            } else {
                $arr['reporter_masked'] = $user->name;
            }
            return $arr;
        });

        $stats = [
            'total'       => Report::where('user_id', $user->id)->count(),
            'pending'     => Report::where('user_id', $user->id)->whereIn('status', ['submitted', 'ai_analysis', 'pending_verification'])->count(),
            'in_progress' => Report::where('user_id', $user->id)->whereIn('status', ['verified', 'assigned', 'in_progress'])->count(),
            'resolved'    => Report::where('user_id', $user->id)->where('status', 'resolved')->count(),
        ];

        return response()->json([
            'data'  => $items,
            'meta'  => [
                'current_page' => $reports->currentPage(),
                'last_page'    => $reports->lastPage(),
                'per_page'     => $reports->perPage(),
                'total'        => $reports->total(),
            ],
            'stats' => $stats,
        ]);
    }

    public function show(Request $request, string $id)
    {
        $report = Report::with([
            'location',
            'images',
            'category',
            'statusHistory.user',
            'analyses.classifications',
            'activeAssignment.operator'
        ])->findOrFail($id);

        $role = $request->user()->role->name;
        $isPubliclyVisible = in_array($report->status, ['verified', 'assigned', 'in_progress', 'resolved'], true);

        abort_unless(
            $report->user_id === $request->user()->id 
            || in_array($role, ['admin', 'operator'], true)
            || $isPubliclyVisible, 
            403
        );

        return response()->json(['report' => $report]);
    }
}