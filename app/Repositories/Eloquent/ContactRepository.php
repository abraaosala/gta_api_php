<?php

namespace App\Repositories\Eloquent;

use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Contact);
    }

    public function create(array $data): Contact
    {
        return $this->model->create($data);
    }
}
