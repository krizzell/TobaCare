<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AdminReportDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $latestAnalysis = $this->analyses->first();
        $activeAssignment = $this->activeAssignment;
        $priorityRec = $this->currentPriorityRecommendation;

        return [
            'report' => [
                'id'                  => $this->id,
                'title'               => $this->title,
                'description'         => $this->description,
                'additional_info'     => $this->additional_info,
                'event_time'          => $this->event_time?->toISOString(),
                'status'              => $this->status,
                'priority_final'      => $this->priority_final,
                'priority_source'     => $this->priority_source,
                'needs_manual_review' => (bool) $this->needs_manual_review,
                'is_public'           => (bool) $this->is_public,
                'merged_into_id'      => $this->merged_into_id,
                'rejection_reason'    => $this->rejection_reason,
                'verified_at'         => $this->verified_at?->toISOString(),
                'created_at'          => $this->created_at?->toISOString(),
            ],
            'reporter' => $this->user ? [
                'id'    => $this->user->id,
                'name'  => $this->user->name,
                'email' => $this->user->email,
            ] : null,
            'category' => $this->category ? [
                'id'   => $this->category->id,
                'code' => $this->category->code,
                'name' => $this->category->name,
            ] : null,
            'location' => $this->location ? [
                'id'           => $this->location->id,
                'latitude'     => (float) $this->location->latitude,
                'longitude'    => (float) $this->location->longitude,
                'address_text' => $this->location->address_text,
                'region'       => $this->location->region,
                'nearby_poi'   => $this->location->nearby_poi,
            ] : null,
            'images' => $this->images->map(fn ($img) => [
                'id'            => $img->id,
                'url'           => Storage::disk('public')->url($img->storage_key),
                'quality_flags' => $img->quality_flags ?? [],
                'sort_order'    => $img->sort_order,
            ])->values()->all(),
            'status_history' => $this->statusHistory->sortBy('created_at')->map(fn ($h) => [
                'from_status' => $h->from_status,
                'to_status'   => $h->to_status,
                'changed_by'  => $h->changedByUser ? [
                    'id'   => $h->changedByUser->id,
                    'name' => $h->changedByUser->name,
                ] : null,
                'note'        => $h->note,
                'created_at'  => $h->created_at?->toISOString(),
            ])->values()->all(),
            'analysis' => $latestAnalysis ? [
                'id'                  => $latestAnalysis->id,
                'status'              => $latestAnalysis->status,
                'model_versions'      => $latestAnalysis->model_versions ?? [],
                'fused_confidence'    => $latestAnalysis->fused_confidence !== null ? (float) $latestAnalysis->fused_confidence : null,
                'needs_manual_review' => (bool) $latestAnalysis->needs_manual_review,
                'error_message'       => $latestAnalysis->error_message,
                'processing_ms'       => $latestAnalysis->processing_ms,
                'classifications'     => $latestAnalysis->classifications->sortBy('rank')->map(fn ($c) => [
                    'id'                    => $c->id,
                    'source'                => $c->source,
                    'rank'                  => $c->rank,
                    'label'                 => $c->label,
                    'subtype'               => $c->subtype,
                    'confidence'            => (float) $c->confidence,
                    'admin_corrected_label' => $c->admin_corrected_label,
                    'verified'              => (bool) $c->verified,
                ])->values()->all(),
            ] : null,
            'priority_recommendation' => $priorityRec ? [
                'id'                => $priorityRec->id,
                'recommended_level' => $priorityRec->recommended_level,
                'score'             => (float) $priorityRec->score,
                'reasoning'         => $priorityRec->reasoning ?? [],
                'admin_final_level' => $priorityRec->admin_final_level,
            ] : null,
            'assignment' => $activeAssignment ? [
                'id'          => $activeAssignment->id,
                'operator'    => $activeAssignment->operator ? [
                    'id'   => $activeAssignment->operator->id,
                    'name' => $activeAssignment->operator->name,
                ] : null,
                'agency'      => $activeAssignment->agency ? [
                    'id'   => $activeAssignment->agency->id,
                    'name' => $activeAssignment->agency->name,
                ] : null,
                'due_date'    => $activeAssignment->due_date?->format('Y-m-d'),
                'note'        => $activeAssignment->note,
                'accepted_at' => $activeAssignment->accepted_at?->toISOString(),
            ] : null,
        ];
    }
}
