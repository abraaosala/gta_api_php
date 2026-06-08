<?php

namespace App\Services\Contracts;

use App\Models\User;

interface AuthServiceInterface
{
    public function login(string $username, string $password): array;

    public function logout(User $user): void;

    public function me(User $user): User;
}
