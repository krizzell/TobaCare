<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AiAnalysis extends Model
{
    use HasUuids;
    protected $table = 'ai_analyses';
    public $timestamps = false;
    protected $fillable = [
    'report_id', 'status', 'model_versions', 'fused_confidence',
    'needs_manual_review', 'processing_ms', 'error_message', 'started_at', 'finished_at',
];
    protected $casts = ['model_versions' => 'array'];

public function classifications() { return $this->hasMany(AiClassification::class); }
}
