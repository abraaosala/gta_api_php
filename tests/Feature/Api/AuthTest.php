<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'admin@gtatech.com',
        'password' => Hash::make('gta2026'),
        'active' => true,
    ]);
});

test('login with valid credentials returns token', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => 'admin@gtatech.com',
        'password' => 'gta2026',
    ]);

    $response->assertOk()
        ->assertJsonStructure(['accessToken', 'user']);
});

test('login with invalid password returns 401', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => 'admin@gtatech.com',
        'password' => 'wrong-password',
    ]);

    $response->assertUnauthorized();
});

test('login with inactive user returns 401', function () {
    $this->user->update(['active' => false]);

    $response = $this->postJson('/api/auth/login', [
        'email' => 'admin@gtatech.com',
        'password' => 'gta2026',
    ]);

    $response->assertUnauthorized();
});

test('me returns authenticated user', function () {
    $token = $this->user->createToken('auth-token')->plainTextToken;

    $response = $this->getJson('/api/auth/me', [
        'Authorization' => "Bearer $token",
    ]);

    $response->assertOk();
});

test('me without token returns 401', function () {
    $this->getJson('/api/auth/me')->assertUnauthorized();
});

test('logout revokes token', function () {
    $token = $this->user->createToken('auth-token')->plainTextToken;

    $this->postJson('/api/auth/logout', [], [
        'Authorization' => "Bearer $token",
    ])->assertNoContent();

    $this->assertEquals(0, $this->user->tokens()->count());
});
