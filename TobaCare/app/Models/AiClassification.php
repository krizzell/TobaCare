<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AiClassification extends Model
{
    use HasUuids;
const UPDATED_AT = null;
protected $fillable = [
    'analysis_id', 'image_id', 'source', 'rank', 'label', 'subtype', 'confidence', 'raw_output',
];
protected $casts = ['raw_output' => 'array'];
}
