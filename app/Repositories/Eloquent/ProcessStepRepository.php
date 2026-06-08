<?php

namespace App\Repositories\Eloquent;

use App\Models\ProcessStep;
use App\Repositories\Contracts\ProcessStepRepositoryInterface;

class ProcessStepRepository extends BaseRepository implements ProcessStepRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new ProcessStep);
    }

    public function find(int|string $id): ?ProcessStep
    {
        return $this->model->find($id);
    }
}
