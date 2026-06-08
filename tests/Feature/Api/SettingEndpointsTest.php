<?php

use App\Models\Setting;
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
    $this->headers = ['Authorization' => 'Bearer '.$this->token];
});

test('public list settings', function () {
    Setting::create(['key' => 'test_key', 'value' => 'test_value']);
    $response = $this->getJson('/api/public/settings');
    $response->assertOk();
    $response->assertJson(['test_key' => 'test_value']);
});

test('admin list settings', function () {
    Setting::create(['key' => 'test_key', 'value' => 'test_value']);
    $response = $this->getJson('/api/admin/settings', $this->headers);
    $response->assertOk()->assertJson(['test_key' => 'test_value']);
});

test('admin update settings', function () {
    $response = $this->putJson('/api/admin/settings', [
        'site_name' => 'GTA Tech',
        'main_color' => '#2563eb',
    ], $this->headers);
    $response->assertOk();
    $response->assertJson(['site_name' => 'GTA Tech', 'main_color' => '#2563eb']);
});

test('admin settings require auth', function () {
    $this->getJson('/api/admin/settings')->assertUnauthorized();
    $this->putJson('/api/admin/settings', [])->assertUnauthorized();
});

test('setting model helpers work', function () {
    Setting::set('foo', 'bar');
    expect(Setting::get('foo'))->toBe('bar');
    expect(Setting::get('nonexistent', 'default'))->toBe('default');
});

test('admin update overwrites existing', function () {
    Setting::create(['key' => 'site_name', 'value' => 'Old']);
    $this->putJson('/api/admin/settings', ['site_name' => 'New'], $this->headers);
    $this->assertEquals('New', Setting::get('site_name'));
});
