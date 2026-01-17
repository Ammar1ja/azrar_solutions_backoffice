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
        $lang = $request->query('lang', 'en');

        return [
            'id' => $this->id,
            'title' => $this->{"{$lang}_title"},
            'description' => $this->{"{$lang}_description"},
            'project_date' => $this->{"{$lang}_project_date"},
            'project_url' => $this->project_url,
            'thumbnail' => $this->thumbnail,
            'project_images' => json_decode($this->project_images),
            'project_video' => $this->project_video,
            'featured' => $this->featured,
            'service' => new ServiceResource($this->service),
            'client' => new ClientResource($this->client),

        ];
    }
}
