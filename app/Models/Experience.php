<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = ['period', 'role', 'org', 'description', 'sort_order'];
}
