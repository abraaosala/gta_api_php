<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ReadServiceInterface
{
    public function list(): Collection;

    public function get(int|string $id): ?Model;
}
