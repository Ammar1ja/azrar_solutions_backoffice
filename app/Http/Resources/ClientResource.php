<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = app()->getLocale(); // default to 'en'

        return [
            'id' => $this->id,
            'name' => $this->{"client_{$lang}_name"}, // dynamically select ar or en
            'logo' => $this->client_logo,
            'website_url' => $this->website_url,
            'country' => $this->whenLoaded('Country', function () use ($lang) {
                return CountryRessource::make($this->Country);
            }),
        ];
    }
}
