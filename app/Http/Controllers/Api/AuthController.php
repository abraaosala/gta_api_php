<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService,
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {

        \Log::info('Login attempt', [
            'all' => $request->all(),
            'validated' => $request->validated(),
            'content_type' => $request->header('Content-Type'),
            'accept' => $request->header('Accept'),
        ]);

        if ($request->missing('username') || $request->missing('password')) {
            \Log::warning('Login missing fields', [
                'has_username' => $request->has('username'),
                'has_password' => $request->has('password'),
                'all' => $request->all(),
                'json' => $request->json()->all(),
            ]);
        }

        $result = $this->authService->login(
            $request->validated('username'),
            $request->validated('password'),
        );

        return response()->json($result);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json(null, 204);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(
            $this->authService->me($request->user()),
        );
    }
}
