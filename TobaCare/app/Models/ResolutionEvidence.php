<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ResolutionEvidence extends Model
{
    use HasUuids;

    const UPDATED_AT = null;

    protected $table = 'resolution_evidences';

    protected $fillable = [
        'report_id',
        'assignment_id',
        'uploaded_by',
        'storage_key',
        'mime_type',
        'size_bytes',
        'note',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute(): ?string
    {
        if (! $this->storage_key) {
            return null;
        }

        return '/storage/' . ltrim($this->storage_key, '/');
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
