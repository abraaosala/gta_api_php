<?php

namespace App\Repositories\Eloquent;

use App\Models\Testimonial;
use App\Repositories\Contracts\TestimonialRepositoryInterface;

class TestimonialRepository extends BaseRepository implements TestimonialRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Testimonial);
    }

    public function find(int|string $id): ?Testimonial
    {
        return $this->model->find($id);
    }
}
