<?php

namespace App\Services;

use App\Models\AiAnalysis;
use App\Models\AiClassification;
use App\Models\Report;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReportAnalysisService
{
    public function run(Report $report): void
    {
        $report->transitionTo('ai_analysis', null, 'Analisis AI dimulai');

        $analysis = AiAnalysis::create([
            'report_id'  => $report->id,
            'status'     => 'pending',
            'started_at' => now(),
        ]);

        $startedAt = microtime(true);
        $best = null;
        $versions = [];
        $status = 'success';
        $error = null;

        try {
            foreach ($report->images as $image) {
                $res = Http::withHeaders(['X-Token' => config('services.ai.token')])
                    ->timeout(config('services.ai.timeout'))
                    ->attach('file', Storage::disk('public')->get($image->storage_key), 'image.jpg')
                    ->post(rtrim(config('services.ai.url'), '/') . '/analyze/image')
                    ->throw()
                    ->json();

                $versions['vision'] = $res['model_version'] ?? null;

                foreach (($res['predictions'] ?? []) as $i => $p) {
                    AiClassification::create([
                        'analysis_id' => $analysis->id,
                        'image_id'    => $image->id,
                        'source'      => 'vision',
                        'rank'        => $i + 1,
                        'label'       => $p['label'],
                        'subtype'     => $p['subtype'] ?? null,
                        'confidence'  => $p['confidence'],
                        'raw_output'  => $p,
                    ]);
                }

                if (! empty($res['quality_flags'])) {
                    $image->update(['quality_flags' => $res['quality_flags']]);
                }

                $top = $res['predictions'][0] ?? null;
                if ($top && (! $best || $top['confidence'] > $best['confidence'])) {
                    $best = $top;
                }
            }
        } catch (\Throwable $e) {
            // kegagalan AI tidak boleh memblokir laporan (PRD AI-05)
            $status = 'failed';
            $error = $e->getMessage();
            Log::warning('AI analysis failed', ['report' => $report->id, 'error' => $error]);
        }

        $needsReview = $status !== 'success'
            || ! $best
            || $best['confidence'] < config('services.ai.conf_low')
            || $best['label'] === 'lainnya'
            || $report->category?->code !== $best['label'];

        $analysis->update([
            'status'              => $status,
            'model_versions'      => $versions,
            'fused_confidence'    => $best['confidence'] ?? null,
            'needs_manual_review' => $needsReview,
            'processing_ms'       => (int) ((microtime(true) - $startedAt) * 1000),
            'error_message'       => $error,
            'finished_at'         => now(),
        ]);

        $report->update(['needs_manual_review' => $needsReview]);
        $report->transitionTo('pending_verification', null, 'Menunggu verifikasi admin');
    }
}