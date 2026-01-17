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
        $lang = $request->query('lang', 'en');

        return [
            'id' => $this->id,
            'title' => $this->{"{$lang}_title"},
            'description' => $this->{"{$lang}_description"},
            'feature_one' => $this->{"{$lang}_feature_one"},
            'feature_two' => $this->{"{$lang}_feature_two"},
            'feature_three' => $this->{"{$lang}_feature_three"},
            'button_text' => $this->{"{$lang}_button_text"},
            'image' => $this->image,
            'video' => $this->video,
            'icon' => $this->icon,
        ];
    }
}
