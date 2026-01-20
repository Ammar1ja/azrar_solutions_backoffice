<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCall extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'date',
        'time',
    ];
}
