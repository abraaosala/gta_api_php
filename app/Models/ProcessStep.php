<?php

namespace App\Models;

use Database\Factories\ProcessStepFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessStep extends Model
{
    /** @use HasFactory<ProcessStepFactory> */
    use HasFactory;

    protected $fillable = [
        'step',
        'title',
        'description',
        'icon',
    ];

    protected function casts(): array
    {
        return [
            'step' => 'integer',
        ];
    }
}
