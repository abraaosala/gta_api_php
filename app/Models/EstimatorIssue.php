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
        'price_multiplier',
    ];

    protected function casts(): array
    {
        return [
            'price_multiplier' => 'decimal:2',
        ];
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(EstimatorDevice::class, 'device_id');
    }
}
