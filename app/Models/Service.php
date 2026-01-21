<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'ar_title',
        'en_title',
        'ar_description',
        'en_description',
        'ar_button_text',
        'en_button_text',
        'image',
        'video',
        'icon',
    ];



    public function Features()
    {
        return $this->hasMany(ServiceFeature::class);
    }


    public function Projects()
    {
        return $this->belongsToMany(Project::class, ProjectService::class);
    }
}
