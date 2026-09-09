<?php

use App\Models\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'username' => 'admin',
        'password' => Hash::make('gta2026'),
        'active' => true,
    ]);
    $this->token = $this->user->createToken('auth-token')->plainTextToken;
    $this->headers = ['Authorization' => "Bearer $this->token"];
});

test('admin list features', function () {
    Feature::factory()->count(3)->create();
    $response = $this->getJson('/api/admin/features', $this->headers);
    $response->assertOk()->assertJsonCount(3, 'data');
});

test('admin create feature', function () {
    $data = Feature::factory()->make()->toArray();
    $response = $this->postJson('/api/admin/features', $data, $this->headers);
    $response->assertCreated();
});

test('admin show feature', function () {
    $feature = Feature::factory()->create();
    $response = $this->getJson("/api/admin/features/{$feature->id}", $this->headers);
    $response->assertOk();
});

test('admin update feature', function () {
    $feature = Feature::factory()->create();
    $response = $this->putJson("/api/admin/features/{$feature->id}", [
        'title' => 'Updated Feature',
    ], $this->headers);
    $response->assertOk();
    $response->assertJsonFragment(['title' => 'Updated Feature']);
});

test('admin delete feature', function () {
    $feature = Feature::factory()->create();
    $response = $this->deleteJson("/api/admin/features/{$feature->id}", [], $this->headers);
    $response->assertNoContent();
});

test('admin features require auth', function () {
    $this->getJson('/api/admin/features')->assertUnauthorized();
});
