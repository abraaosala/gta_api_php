<?php

namespace App\Repositories\Contracts;

use App\Models\EstimatorDevice;

interface EstimatorDeviceRepositoryInterface
{
    public function find(int|string $id): ?EstimatorDevice;
}
