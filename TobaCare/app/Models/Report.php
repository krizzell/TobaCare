<?php

namespace App\Models;

use App\Exceptions\ApiException;
use App\Support\ReportTransitions;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'description', 'additional_info',
        'event_time', 'status', 'priority_final', 'priority_source',
        'needs_manual_review', 'is_public', 'merged_into_id', 'rejection_reason',
        'verified_at', 'resolved_at', 'closed_at',
    ];

    protected $casts = [
        'needs_manual_review' => 'boolean',
        'is_public'           => 'boolean',
        'event_time'          => 'datetime',
        'verified_at'         => 'datetime',
        'resolved_at'         => 'datetime',
        'closed_at'           => 'datetime',
    ];

    protected $appends = ['thumbnail_url'];

    public function getThumbnailUrlAttribute(): ?string
    {
        $first = $this->relationLoaded('images') ? $this->images->first() : $this->images()->first();
        return $first?->url;
    }

    public function user()          { return $this->belongsTo(User::class); }
    public function location()      { return $this->hasOne(Location::class); }
    public function images()        { return $this->hasMany(ReportImage::class)->orderBy('sort_order'); }
    public function category()      { return $this->belongsTo(Category::class); }
    public function statusHistory() { return $this->hasMany(ReportStatusHistory::class)->orderBy('created_at'); }
    public function analyses()      { return $this->hasMany(AiAnalysis::class)->orderBy('started_at', 'desc'); }
    public function assignments()   { return $this->hasMany(Assignment::class); }
    public function activeAssignment() { return $this->hasOne(Assignment::class)->where('is_active', true); }
    public function priorityRecommendations() { return $this->hasMany(PriorityRecommendation::class); }
    public function currentPriorityRecommendation() { return $this->hasOne(PriorityRecommendation::class)->where('is_current', true); }
    public function resolutionEvidences() { return $this->hasMany(ResolutionEvidence::class)->orderBy('created_at', 'desc'); }

    public function transitionTo(string $to, ?string $userId = null, ?string $note = null, array $attributes = []): void
    {
        $from = $this->status;
        if ($from !== null && ! ReportTransitions::allowed($from, $to)) {
            throw new ApiException(
                'INVALID_TRANSITION',
                "Transisi status dari {$from} ke {$to} tidak diizinkan",
                409,
                ['from' => $from, 'to' => $to]
            );
        }

        $this->update(array_merge(['status' => $to], $attributes));
        $this->statusHistory()->create([
            'from_status' => $from,
            'to_status'   => $to,
            'changed_by'  => $userId,
            'note'        => $note,
        ]);
    }
}