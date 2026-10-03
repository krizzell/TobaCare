<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PriorityRecommendation extends Model
{
    use HasUuids;

    const UPDATED_AT = null;

    protected $fillable = [
        'report_id',
        'recommended_level',
        'score',
        'reasoning',
        'admin_final_level',
        'decided_by',
        'decided_at',
        'is_current',
    ];

    protected $casts = [
        'score'       => 'float',
        'reasoning'   => 'array',
        'is_current'  => 'boolean',
        'decided_at'  => 'datetime',
        'created_at'  => 'datetime',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function decidedBy()
    {
        return $this->belongsTo(User::class, 'decided_by');
    }
}
