<?php

namespace App\Repositories\Contracts;

use App\Models\Brand;

interface BrandRepositoryInterface
{
    public function find(int|string $id): ?Brand;
}
