<?php

namespace App\Models;

use Database\Factories\EstimatorIssueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstimatorIssue extends Model
{
    /** @use HasFactory<EstimatorIssueFactory> */
    use HasFactory;

    protected $fillable = [
        'device_id',
        'name',
        'base_price',
        'estimated_time',
        'price_multiplier',
    ];

    protected function casts(): array
    {
        return [
            'price_multiplier' => 'decimal:2',
        ];
    }

    protected $appends = ['local_price'];

    public function getLocalPriceAttribute(): float
    {
        if ($this->base_price !== null) {
            return (float) $this->base_price;
        }

        $device = $this->relationLoaded('device') ? $this->device : $this->device()->first();

        return (float) ($device?->base_price ?? 0) * (float) ($this->price_multiplier ?? 1);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(EstimatorDevice::class, 'device_id');
    }
}
