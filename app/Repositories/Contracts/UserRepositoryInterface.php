<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findByUsername(string $username): ?User;

    public function updateLastLogin(User $user): void;
}
