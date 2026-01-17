<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    public function client()
    {
        return $this->BelongsTo(Country::class);
    }

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
