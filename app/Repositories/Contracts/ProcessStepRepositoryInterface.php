<?php

namespace App\Repositories\Contracts;

use App\Models\ProcessStep;

interface ProcessStepRepositoryInterface
{
    public function find(int|string $id): ?ProcessStep;
}
