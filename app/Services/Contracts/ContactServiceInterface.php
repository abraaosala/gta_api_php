<?php

namespace App\Services\Contracts;

use App\Models\Contact;

interface ContactServiceInterface
{
    public function store(array $data): Contact;
}
