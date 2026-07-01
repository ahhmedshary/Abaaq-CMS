<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name', 'role', 'tagline', 'location', 'email',
        'avatar', 'resume_url', 'social', 'stats',
    ];

    protected $casts = [
        'social' => 'array',
        'stats' => 'array',
    ];
}
