<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ReportImage extends Model
{
    use HasUuids;

    const UPDATED_AT = null;

    protected $fillable = [
        'report_id', 'uploaded_by', 'storage_key', 'mime_type', 'size_bytes',
        'width', 'height', 'file_hash', 'quality_flags', 'sort_order',
    ];

    protected $casts = ['quality_flags' => 'array'];
}