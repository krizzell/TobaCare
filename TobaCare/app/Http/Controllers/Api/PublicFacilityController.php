<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicFacilityController extends Controller
{
    /**
     * GET /api/v1/public/resolved-facilities
     * Public showcase of facilities repaired by the local government (Kabupaten Toba).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Report::query()
            ->where('status', 'resolved')
            ->with([
                'category.defaultAgency',
                'location',
                'images',
                'statusHistory.user',
                'activeAssignment.agency',
            ]);

        // Filter by category
        if ($categoryId = $request->query('category_id')) {
            $query->where('category_id', $categoryId);
        }

        // Filter by category code
        if ($categoryCode = $request->query('category_code')) {
            $query->whereHas('category', function ($q) use ($categoryCode) {
                $q->where('code', $categoryCode);
            });
        }

        // Search in title, description, or address
        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%")
                  ->orWhereHas('location', function ($lq) use ($search) {
                      $lq->where('address_text', 'ilike', "%{$search}%")
                         ->orWhere('region', 'ilike', "%{$search}%");
                  });
            });
        }

        // Filter by region / district
        if ($region = $request->query('region')) {
            $query->whereHas('location', function ($q) use ($region) {
                $q->where('address_text', 'ilike', "%{$region}%")
                  ->orWhere('region', 'ilike', "%{$region}%");
            });
        }

        $perPage = $request->integer('per_page', 9);
        $facilities = $query->latest('resolved_at')->latest('updated_at')->paginate($perPage);

        // Map facilities with citizen-friendly presentation
        $items = collect($facilities->items())->map(function ($r) {
            $firstImg = $r->thumbnail_url;
            if (! $firstImg && $r->images && $r->images->isNotEmpty()) {
                $firstImg = $r->images->first()->url;
            }

            // Find resolution note from status history
            $resolutionEntry = $r->statusHistory
                ? $r->statusHistory->firstWhere('to_status', 'resolved')
                : null;

            $resolutionNote = $resolutionEntry?->note ?? $r->additional_info;
            $agency = $r->activeAssignment?->agency?->name
                ?? $r->category?->defaultAgency?->name;

            return [
                'id'              => $r->id,
                'title'           => $r->title,
                'description'     => $r->description,
                'category'        => $r->category ? [
                    'id'   => $r->category->id,
                    'name' => $r->category->name,
                    'code' => $r->category->code,
                ] : null,
                'location'        => $r->location ? [
                    'address'   => $r->location->address_text,
                    'latitude'  => (float) $r->location->latitude,
                    'longitude' => (float) $r->location->longitude,
                ] : null,
                'thumbnail_url'   => $firstImg,
                'images'          => $r->images ? $r->images->map(fn ($img) => [
                    'id'   => $img->id,
                    'url'  => $img->url,
                ]) : [],
                'managing_agency' => $agency,
                'resolved_at'     => $r->resolved_at ?? $resolutionEntry?->created_at ?? $r->updated_at,
                'resolution_note' => $resolutionNote,
            ];
        });

        // Summary stats
        $totalResolved = Report::where('status', 'resolved')->count();
        $publicResolved = Report::where('status', 'resolved')->where('is_public', true)->count();
        $averageResolutionHours = Report::query()
            ->where('status', 'resolved')
            ->whereNotNull('resolved_at')
            ->selectRaw('AVG(EXTRACT(EPOCH FROM (resolved_at - created_at)) / 3600) as hours')
            ->value('hours');
        $categoriesStats = Category::where('is_active', true)
            ->withCount(['reports' => function ($q) {
                $q->where('status', 'resolved');
            }])
            ->get()
            ->map(fn ($c) => [
                'id'    => $c->id,
                'name'  => $c->name,
                'code'  => $c->code,
                'count' => $c->reports_count,
            ]);

        return response()->json([
            'data'  => $items,
            'meta'  => [
                'current_page' => $facilities->currentPage(),
                'last_page'    => $facilities->lastPage(),
                'per_page'     => $facilities->perPage(),
                'total'        => $facilities->total(),
            ],
            'stats' => [
                'total_resolved'     => $totalResolved,
                'public_resolved'    => $publicResolved,
                'avg_resolution_days'=> $averageResolutionHours === null ? null : round($averageResolutionHours / 24, 1),
                'public_transparency'=> $totalResolved > 0 ? round(($publicResolved / $totalResolved) * 100, 1) : null,
                'categories'         => $categoriesStats,
                'districts_coverage' => Location::query()
                    ->whereNotNull('region')
                    ->whereHas('report', fn ($query) => $query->where('status', 'resolved'))
                    ->distinct()
                    ->count('region'),
            ],
        ]);
    }

    /**
     * GET /api/v1/public/resolved-facilities/{id}
     */
    public function show(string $id): JsonResponse
    {
        $report = Report::query()
            ->where('status', 'resolved')
            ->with([
                'category.defaultAgency',
                'location',
                'images',
                'statusHistory.user',
                'activeAssignment.agency',
            ])
            ->findOrFail($id);

        $firstImg = $report->thumbnail_url;
        if (! $firstImg && $report->images && $report->images->isNotEmpty()) {
            $firstImg = $report->images->first()->url;
        }

        $resolutionEntry = $report->statusHistory
            ? $report->statusHistory->firstWhere('to_status', 'resolved')
            : null;

        $agency = $report->activeAssignment?->agency?->name
            ?? $report->category?->defaultAgency?->name;

        return response()->json([
            'facility' => [
                'id'              => $report->id,
                'title'           => $report->title,
                'description'     => $report->description,
                'additional_info' => $report->additional_info,
                'category'        => $report->category,
                'location'        => $report->location,
                'thumbnail_url'   => $firstImg,
                'images'          => $report->images,
                'managing_agency' => $agency,
                'resolved_at'     => $report->resolved_at ?? $resolutionEntry?->created_at ?? $report->updated_at,
                'resolution_note' => $resolutionEntry?->note ?? $report->additional_info,
                'timeline'        => $report->statusHistory,
            ],
        ]);
    }
}
