<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'title', 'category', 'description', 'sort_order', 'active'];

    protected $casts = [
        'category' => 'string',
        'sort_order' => 'integer',
        'active' => 'boolean',
    ];
}
