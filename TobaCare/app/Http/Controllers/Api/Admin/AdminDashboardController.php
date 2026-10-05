<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiAnalysis;
use App\Models\Category;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * GET /api/v1/admin/dashboard/stats
     * Provides aggregated metrics, trending time series, and distributions for the interactive dashboard.
     */
    public function stats(Request $request): JsonResponse
    {
        $totalReports = Report::count();
        $pendingCount = Report::where('status', 'pending_verification')->count();
        $inProgressCount = Report::where('status', 'in_progress')->count();
        $resolvedCount = Report::where('status', 'resolved')->count();
        $assignedCount = Report::where('status', 'assigned')->count();

        // 10-day trending time series for line chart, based on actual report categories.
        $timeline = [];
        for ($i = 9; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $label = $date->translatedFormat('d M');

            $reports = Report::query()
                ->with('category:id,code,name')
                ->whereDate('created_at', $dateStr)
                ->get(['category_id']);
            $categoryCount = function (array $terms) use ($reports): int {
                return $reports->filter(function ($report) use ($terms): bool {
                    if (! $report->category) {
                        return false;
                    }
                    $value = strtolower($report->category->code . ' ' . $report->category->name);
                    return collect($terms)->contains(fn (string $term) => str_contains($value, $term));
                })->count();
            };

            $timeline[] = [
                'date'          => $dateStr,
                'label'         => $label,
                'total'         => $reports->count(),
                'infrastruktur' => $categoryCount(['jalan', 'drainase', 'lampu', 'infrastruktur']),
                'kebersihan'    => $categoryCount(['sampah', 'kebersihan']),
                'fasum'         => $categoryCount(['fasum', 'fasilitas', 'umum']),
            ];
        }

        // Category breakdown for donut chart
        $categories = Category::where('is_active', true)
            ->withCount('reports')
            ->get();

        $totalCatReports = $categories->sum('reports_count');
        $categoryBreakdown = $categories->map(function ($cat) use ($totalCatReports) {
            return [
                'id'         => $cat->id,
                'name'       => $cat->name,
                'count'      => $cat->reports_count,
                'percentage' => $totalCatReports > 0
                    ? round(($cat->reports_count / $totalCatReports) * 100, 1)
                    : 0,
            ];
        });

        $averageAiConfidence = AiAnalysis::query()
            ->where('status', 'success')
            ->whereNotNull('fused_confidence')
            ->avg('fused_confidence');
        $averageResolutionHours = Report::query()
            ->where('status', 'resolved')
            ->whereNotNull('resolved_at')
            ->selectRaw('AVG(EXTRACT(EPOCH FROM (resolved_at - created_at)) / 3600) as hours')
            ->value('hours');

        // Recent 5 reports for the scorecard table
        $recentReports = Report::query()
            ->with(['category', 'location', 'activeAssignment.operator', 'currentPriorityRecommendation'])
            ->latest('created_at')
            ->limit(5)
            ->get()
            ->map(function ($r) {
                return [
                    'id'              => $r->id,
                    'title'           => $r->title,
                    'category'        => $r->category?->name,
                    'priority'        => $r->priority_final ?? $r->currentPriorityRecommendation?->priority,
                    'status'          => $r->status,
                    'location'        => $r->location?->address_text,
                    'operator'        => $r->activeAssignment?->operator?->name,
                    'created_at_diff' => $r->created_at?->diffForHumans(),
                ];
            });

        return response()->json([
            'kpis' => [
                'total_reports'        => $totalReports,
                'pending_verification' => $pendingCount,
                'in_progress'          => $inProgressCount,
                'resolved'             => $resolvedCount,
                'assigned'             => $assignedCount,
                'ai_verified_rate'     => $averageAiConfidence === null ? null : round($averageAiConfidence * 100, 1) . '%',
                'avg_resolution_sla'   => $averageResolutionHours === null ? null : round($averageResolutionHours / 24, 1) . ' Hari',
            ],
            'timeline'           => $timeline,
            'category_breakdown' => $categoryBreakdown,
            'recent_reports'     => $recentReports,
        ]);
    }
}
