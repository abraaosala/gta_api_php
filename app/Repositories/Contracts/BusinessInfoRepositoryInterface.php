<?php

namespace App\Repositories\Contracts;

use App\Models\BusinessInfo;

interface BusinessInfoRepositoryInterface
{
    public function find(string $id): ?BusinessInfo;

    public function getMain(): ?BusinessInfo;
}
