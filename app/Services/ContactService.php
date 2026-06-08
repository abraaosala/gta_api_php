<?php

namespace App\Services;

use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;
use App\Services\Contracts\ContactServiceInterface;

class ContactService implements ContactServiceInterface
{
    public function __construct(
        protected ContactRepositoryInterface $contactRepository,
    ) {}

    public function store(array $data): Contact
    {
        return $this->contactRepository->create($data);
    }
}
