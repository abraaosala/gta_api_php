<?php

use App\Models\Team;
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

test('public list team', function () {
    Team::factory()->count(3)->create(['active' => true]);
    $response = $this->getJson('/api/public/team');
    $response->assertOk()->assertJsonCount(3, 'data');
});

test('public only shows active team', function () {
    Team::factory()->create(['active' => true]);
    Team::factory()->create(['active' => false]);
    $response = $this->getJson('/api/public/team');
    $response->assertOk()->assertJsonCount(1, 'data');
});

test('admin list team', function () {
    Team::factory()->count(3)->create();
    $this->getJson('/api/admin/team', $this->headers)->assertOk()->assertJsonCount(3);
});

test('admin create team member', function () {
    $data = Team::factory()->make()->toArray();
    $this->postJson('/api/admin/team', $data, $this->headers)->assertCreated();
});

test('admin show team member', function () {
    $item = Team::factory()->create();
    $this->getJson("/api/admin/team/{$item->id}", $this->headers)->assertOk();
});

test('admin update team member', function () {
    $item = Team::factory()->create();
    $this->putJson("/api/admin/team/{$item->id}", ['name' => 'Updated'], $this->headers)->assertOk();
});

test('admin delete team member', function () {
    $item = Team::factory()->create();
    $this->deleteJson("/api/admin/team/{$item->id}", [], $this->headers)->assertNoContent();
});

test('admin team requires auth', function () {
    $this->getJson('/api/admin/team')->assertUnauthorized();
});
