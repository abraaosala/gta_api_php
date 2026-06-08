<?php

namespace App\Repositories\Contracts;

use App\Models\Faq;

interface FaqRepositoryInterface
{
    public function find(int|string $id): ?Faq;
}
