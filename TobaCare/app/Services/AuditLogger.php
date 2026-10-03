<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;

class AuditLogger
{
    public function log(
        User $actor,
        string $action,
        string $entityType,
        ?string $entityId,
        ?array $before,
        ?array $after,
        ?string $ip = null
    ): AuditLog {
        return AuditLog::create([
            'actor_id'    => $actor->id,
            'action'      => $action,
            'entity_type' => $entityType,
            'entity_id'   => $entityId,
            'before_data' => $before,
            'after_data'  => $after,
            'ip_address'  => $ip,
            'created_at'  => now(),
        ]);
    }
}
