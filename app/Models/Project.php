<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'category', 'year', 'description',
        'image', 'tags', 'link', 'sort_order', 'is_published',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
    ];
}
