<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable = [
        'client_id',
        'ar_title',
        'en_title',
        'ar_description',
        'en_description',
        'project_url',
        'date',
        'thumbnail',
        'project_images',
        'project_video',
        'featured',
    ];

    protected $casts = [
        'project_images' => 'array',
    ];
    public function Services()
    {
        return $this->belongsToMany(Service::class, ProjectService::class);
    }

    public function Client()
    {
        return $this->belongsTo(Client::class);
    }
}
