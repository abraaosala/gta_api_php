<?php

namespace App\Services;

use App\Services\Contracts\ReadServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ReadService implements ReadServiceInterface
{
    public function __construct(protected Model $model) {}

    public function list(): Collection
    {
        return $this->model->all();
    }

    public function get(int|string $id): ?Model
    {
        return $this->model->find($id);
    }
}
