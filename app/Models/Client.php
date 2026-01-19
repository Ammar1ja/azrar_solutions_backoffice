<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    public function project()
    {
        return $this->hasMany(Project::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
