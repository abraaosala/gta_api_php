<?php

namespace App\Repositories\Eloquent;

use App\Models\BusinessInfo;
use App\Repositories\Contracts\BusinessInfoRepositoryInterface;

class BusinessInfoRepository extends BaseRepository implements BusinessInfoRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new BusinessInfo);
    }

    public function find(string $id): ?BusinessInfo
    {
        return $this->model->find($id);
    }

    public function getMain(): ?BusinessInfo
    {
        return $this->model->where('id', 'main')->first();
    }
}
