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
        $lang = $request->query('lang', 'en'); // default to 'en'

        return [
            'id' => $this->id,
            'name' => $this->{"client_{$lang}_name"}, // dynamically select ar or en
            'logo' => $this->client_logo,
            'website_url' => $this->website_url,
            'country_id' => $this->country_id,
        ];
    }
}
