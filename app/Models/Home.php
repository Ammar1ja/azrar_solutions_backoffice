<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $fillable = [
        'hero_en_title',
        'hero_ar_title',
        'hero_en_subtitle',
        'hero_ar_subtitle',
        'hero_en_button_text',
        'hero_ar_button_text',
        'hero_background',
    ];
    
}
