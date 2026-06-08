<?php

namespace App\Repositories\Eloquent;

use App\Models\Brand;
use App\Repositories\Contracts\BrandRepositoryInterface;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Brand);
    }

    public function find(int|string $id): ?Brand
    {
        return $this->model->find($id);
    }
}
