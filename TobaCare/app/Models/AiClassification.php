<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AiClassification extends Model
{
    use HasUuids;
const UPDATED_AT = null;
    protected $fillable = [
        'analysis_id', 'image_id', 'source', 'rank', 'label', 'subtype', 'confidence',
        'raw_output', 'admin_corrected_label', 'corrected_by', 'corrected_at',
        'correction_reason', 'verified',
    ];

    protected $casts = [
        'raw_output'   => 'array',
        'verified'     => 'boolean',
        'confidence'   => 'float',
        'corrected_at' => 'datetime',
    ];

    public function analysis()
    {
        return $this->belongsTo(AiAnalysis::class);
    }

    public function image()
    {
        return $this->belongsTo(ReportImage::class, 'image_id');
    }

    public function correctedByUser()
    {
        return $this->belongsTo(User::class, 'corrected_by');
    }
}
