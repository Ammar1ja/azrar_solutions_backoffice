<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'name', // e.g., category name
    ];

    /**
     * Relationship: Category has many blogs
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
