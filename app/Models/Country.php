<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_en',
        'name_ar',
        'iso2',
        'flag', // This will now store the file path string (e.g., "flags/filename.jpg")
    ];

    /**
     * Relationship with Clients.
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
