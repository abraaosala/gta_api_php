<?php

use App\Models\Gallery;
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

test('public list galleries', function () {
    Gallery::factory()->count(3)->create(['active' => true]);
    $response = $this->getJson('/api/public/gallery');
    $response->assertOk()->assertJsonCount(3, 'data');
});

test('public only shows active galleries', function () {
    Gallery::factory()->create(['active' => true]);
    Gallery::factory()->create(['active' => false]);
    $response = $this->getJson('/api/public/gallery');
    $response->assertOk()->assertJsonCount(1, 'data');
});

test('admin list galleries', function () {
    Gallery::factory()->count(3)->create();
    $this->getJson('/api/admin/gallery', $this->headers)->assertOk()->assertJsonCount(3);
});

test('admin create gallery', function () {
    $data = Gallery::factory()->make()->toArray();
    $this->postJson('/api/admin/gallery', $data, $this->headers)->assertCreated();
});

test('admin show gallery', function () {
    $item = Gallery::factory()->create();
    $this->getJson("/api/admin/gallery/{$item->id}", $this->headers)->assertOk();
});

test('admin update gallery', function () {
    $item = Gallery::factory()->create();
    $this->putJson("/api/admin/gallery/{$item->id}", ['title' => 'Updated'], $this->headers)->assertOk();
});

test('admin delete gallery', function () {
    $item = Gallery::factory()->create();
    $this->deleteJson("/api/admin/gallery/{$item->id}", [], $this->headers)->assertNoContent();
});

test('admin galleries require auth', function () {
    $this->getJson('/api/admin/gallery')->assertUnauthorized();
});
