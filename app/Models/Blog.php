<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'image',
        'title',
        'body',
        'description',
        'country_id',
    ];

    /**
     * Relationship: Blog belongs to one category
     */
    public function Categories()
    {
        return $this->belongsToMany(Category::class, BlogCategory::class);
    }
    /**
     * Relationship: Blog belongs to many tags
     */
    public function Tags()
    {
        return $this->hasMany(related: BlogTag::class);
    }


    public function Views()
    {
        return $this->hasMany(BlogView::class);
    }


    public function Countries()
    {
        return $this->belongsToMany(Country::class, BlogCountry::class);
    }
}
