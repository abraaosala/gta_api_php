<?php

namespace App\Repositories\Contracts;

use App\Models\Testimonial;

interface TestimonialRepositoryInterface
{
    public function find(int|string $id): ?Testimonial;
}
