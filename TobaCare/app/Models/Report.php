<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'description', 'additional_info',
        'event_time', 'status', 'needs_manual_review', 'is_public',
    ];

    public function location()      { return $this->hasOne(Location::class); }
    public function images()        { return $this->hasMany(ReportImage::class)->orderBy('sort_order'); }
    public function category()      { return $this->belongsTo(Category::class); }
    public function statusHistory() { return $this->hasMany(ReportStatusHistory::class)->orderBy('created_at'); }
    public function analyses()      { return $this->hasMany(AiAnalysis::class); }

    public function transitionTo(string $to, ?string $userId = null, ?string $note = null): void
    {
        $from = $this->status;
        $this->update(['status' => $to]);
        $this->statusHistory()->create([
            'from_status' => $from, 'to_status' => $to,
            'changed_by' => $userId, 'note' => $note,
        ]);
    }
}