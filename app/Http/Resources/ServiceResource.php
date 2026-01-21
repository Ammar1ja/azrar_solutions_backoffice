<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = app()->getLocale();

        return [
            'id' => $this->id,
            'title' => $this->{"{$lang}_title"},
            'description' => $this->{"{$lang}_description"},
            'button_text' => $this->{"{$lang}_button_text"},
            'image' => asset('storage/' . $this->image),
            'video' => asset('storage/' . $this->video),
            'icon' => asset('storage/' . $this->icon),
            'features' => ServiceFeatureResource::collection($this->whenLoaded('Features')),
            'projects' => $this->whenLoaded('Projects', function () {
                return ProjectResource::collection($this->Projects);
            }),
        ];
    }
}
