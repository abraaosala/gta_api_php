<?php

namespace App\Repositories\Eloquent;

use App\Models\Faq;
use App\Repositories\Contracts\FaqRepositoryInterface;

class FaqRepository extends BaseRepository implements FaqRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Faq);
    }

    public function find(int|string $id): ?Faq
    {
        return $this->model->find($id);
    }
}
