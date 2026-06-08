<?php

namespace App\Repositories\Eloquent;

use App\Models\EstimatorDevice;
use App\Repositories\Contracts\EstimatorDeviceRepositoryInterface;

class EstimatorDeviceRepository extends BaseRepository implements EstimatorDeviceRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new EstimatorDevice);
    }

    public function find(int|string $id): ?EstimatorDevice
    {
        return $this->model->with('issues')->find($id);
    }
}
