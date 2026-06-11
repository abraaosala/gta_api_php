<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function login(string $email, string $password): array
    {
        $user = $this->userRepository->findByEmail($email);

        if (! $user || ! $user->active || ! Hash::check($password, $user->password)) {
            throw new AuthenticationException('Invalid credentials');
        }

        $this->userRepository->updateLastLogin($user);

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'accessToken' => $token,
            'user' => $user->only(['id', 'username', 'name', 'display_name', 'role']),
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function me(User $user): User
    {
        return $user;
    }

    public function refresh(User $user): array
    {
        $user->currentAccessToken()->delete();

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'accessToken' => $token,
            'user' => $user->only(['id', 'username', 'name', 'display_name', 'role']),
        ];
    }
}
