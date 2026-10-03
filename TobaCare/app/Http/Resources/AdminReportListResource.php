<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AdminReportListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $latestAnalysis = $this->analyses->first();
        $topClassification = $latestAnalysis ? $latestAnalysis->classifications->where('rank', 1)->first() : null;

        $firstImage = $this->images->first();
        $thumbnailUrl = $firstImage ? Storage::disk('public')->url($firstImage->storage_key) : null;

        return [
            'id'                  => $this->id,
            'title'               => $this->title,
            'status'              => $this->status,
            'category'            => $this->category ? [
                'id'   => $this->category->id,
                'code' => $this->category->code,
                'name' => $this->category->name,
            ] : null,
            'priority_final'      => $this->priority_final,
            'needs_manual_review' => (bool) $this->needs_manual_review,
            'ai'                  => [
                'status'           => $latestAnalysis?->status,
                'top_label'        => $topClassification?->label,
                'top_confidence'   => $topClassification ? (float) $topClassification->confidence : null,
                'fused_confidence' => $latestAnalysis?->fused_confidence !== null ? (float) $latestAnalysis->fused_confidence : null,
            ],
            'location'            => $this->location ? [
                'latitude'     => (float) $this->location->latitude,
                'longitude'    => (float) $this->location->longitude,
                'address_text' => $this->location->address_text,
            ] : null,
            'thumbnail_url'       => $thumbnailUrl,
            'created_at'          => $this->created_at?->toISOString(),
        ];
    }
}
