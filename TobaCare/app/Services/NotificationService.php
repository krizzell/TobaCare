<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Str;

class NotificationService
{
    private const ALLOWED_TYPES = [
        'report_submitted',
        'report_verified',
        'report_assigned',
        'status_changed',
        'report_resolved',
        'info_requested',
    ];

    public function notify(
        string $userId,
        ?string $reportId,
        string $type,
        string $message,
        ?string $actorId = null
    ): ?Notification {
        $currentUserId = $actorId ?? auth()->id();
        if ($currentUserId && $userId === $currentUserId) {
            return null;
        }

        if (! in_array($type, self::ALLOWED_TYPES, true)) {
            throw new \InvalidArgumentException("Invalid notification type: {$type}");
        }

        return Notification::create([
            'user_id'    => $userId,
            'report_id'  => $reportId,
            'type'       => $type,
            'message'    => Str::limit($message, 255, ''),
            'is_read'    => false,
            'created_at' => now(),
        ]);
    }
}
