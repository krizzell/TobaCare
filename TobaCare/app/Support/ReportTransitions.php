<?php

namespace App\Support;

class ReportTransitions
{
    private const TRANSITIONS = [
        'submitted'            => ['ai_analysis'],
        'ai_analysis'          => ['pending_verification'],
        'pending_verification' => ['verified', 'rejected'],
        'verified'             => ['assigned'],
        'assigned'             => ['in_progress'],
        'in_progress'          => ['resolved'],
        'resolved'             => ['closed'],
    ];

    public static function allowed(string $from, string $to): bool
    {
        return in_array($to, self::TRANSITIONS[$from] ?? [], true);
    }
}
