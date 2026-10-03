<?php

namespace App\Services;

use App\Models\Report;
use App\Models\User;

class AiCorrectionService
{
    /**
     * Apply human confirmation or correction to AI classifications.
     *
     * @return array<\App\Models\AiClassification>
     */
    public function applyHumanLabel(
        Report $report,
        string $categoryCode,
        User $admin,
        ?string $reason = null,
        ?string $subtype = null
    ): array {
        $latestAnalysis = $report->analyses()->latest('started_at')->first();
        if (! $latestAnalysis) {
            return [];
        }

        $classifications = $latestAnalysis->classifications()
            ->where('rank', 1)
            ->get();

        if ($classifications->isEmpty()) {
            return [];
        }

        $modified = [];

        foreach ($classifications as $classification) {
            if ($subtype !== null) {
                $raw = $classification->raw_output ?? [];
                if (! isset($raw['admin_correction']) || ! is_array($raw['admin_correction'])) {
                    $raw['admin_correction'] = [];
                }
                $raw['admin_correction']['subtype'] = $subtype;
                $classification->raw_output = $raw;
            }

            if ($classification->label === $categoryCode) {
                $classification->verified = true;
            } else {
                $classification->admin_corrected_label = $categoryCode;
                $classification->corrected_by = $admin->id;
                $classification->corrected_at = now();
                $classification->correction_reason = $reason;
                $classification->verified = true;
            }

            $classification->save();
            $modified[] = $classification;
        }

        return $modified;
    }
}
