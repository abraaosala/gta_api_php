<?php

namespace App\Models;

use Database\Factories\EstimatorDeviceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstimatorDevice extends Model
{
    /** @use HasFactory<EstimatorDeviceFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'base_price',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
        ];
    }

    public function issues(): HasMany
    {
        return $this->hasMany(EstimatorIssue::class, 'device_id');
    }
}
