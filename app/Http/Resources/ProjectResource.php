<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'project_date' => $this->{"{$lang}_project_date"},
            'project_url' => $this->project_url,
            'thumbnail' => $this->thumbnail,
            'project_images' => collect($this->project_images)->map(function ($image) {
                return asset('storage/' . $image);
            }),
            'project_video' => $this->project_video,
            'featured' => $this->featured,
            'services' => $this->whenLoaded('Services', function () use ($lang) {
                return ServiceResource::collection($this->Services)->map(function ($service) use ($lang) {
                    return [
                        'id' => $service->id,
                        'title' => $service->{"{$lang}_title"},
                    ];
                });
            }),
            'client' => $this->whenLoaded('Client', function () {
                return new ClientResource($this->Client);
            }),

        ];
    }
}
