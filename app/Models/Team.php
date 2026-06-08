<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'role', 'photo', 'bio', 'social_links', 'sort_order', 'active'];

    protected $casts = [
        'social_links' => 'array',
        'sort_order' => 'integer',
        'active' => 'boolean',
    ];
}
