<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{

    protected $fillable = [
        'client_ar_name',
        'client_en_name',
        'client_logo',
        'website_url',
        'country_id', // This comes from foreignIdFor(Country::class)
    ];

    public function Country()
    {
        return $this->belongsTo(Country::class);
    }
}
