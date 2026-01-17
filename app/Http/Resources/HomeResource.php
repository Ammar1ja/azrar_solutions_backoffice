<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $lang = $request->query('lang', 'en'); // default to 'en'

        return [
            'id' => $this->id,

            // Hero section
            'hero' => [
                'title' => $this->{"hero_{$lang}_title"},
                'subtitle' => $this->{"hero_{$lang}_subtitle"},
                'button_text' => $this->{"hero_{$lang}_button_text"},
                'background' => $this->hero_background,
            ],

            // Why Azrar section
            'why_azrar' => [
                'title' => $this->{"why_azrar_{$lang}_title"},
            ],

            // About section
            'about' => [
                'title' => $this->{"about_{$lang}_title"},
                'paragraph_one' => $this->{"about_{$lang}_paragraph_one"},
                'paragraph_two' => $this->{"about_{$lang}_paragraph_two"},
                'button_text' => $this->{"about_{$lang}_button_text"},
            ],

            // Meta section
            'meta' => [
                'title' => $this->{"meta_{$lang}_title"},
                'description' => $this->{"meta_{$lang}_description"},
                'button_text' => $this->{"meta_{$lang}_button_text"},
            ],

            // Journey section
            'journey' => [
                'title' => $this->{"journey_{$lang}_title"},
                'paragraph_one' => $this->{"journey_{$lang}_paragraph_one"},
                'paragraph_two' => $this->{"journey_{$lang}_paragraph_two"},
                'image' => $this->journey_image,
                'button_text' => $this->{"journey_{$lang}_button_text"},
            ],

            // Timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
