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
        'category_id', // assuming you still have a category relationship
    ];

    /**
     * Relationship: Blog belongs to one category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship: Blog belongs to many tags
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag');
    }
}
