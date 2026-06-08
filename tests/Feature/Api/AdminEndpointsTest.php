<?php

use App\Models\Brand;
use App\Models\BusinessInfo;
use App\Models\Contact;
use App\Models\EstimatorDevice;
use App\Models\EstimatorIssue;
use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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

// Services CRUD
test('admin list services', function () {
    Service::factory()->count(3)->create();
    $this->getJson('/api/admin/services', $this->headers)->assertOk()->assertJsonCount(3);
});

test('admin create service', function () {
    $data = Service::factory()->make()->toArray();
    $this->postJson('/api/admin/services', $data, $this->headers)->assertCreated();
});

test('admin show service', function () {
    $service = Service::factory()->create();
    $this->getJson("/api/admin/services/{$service->id}", $this->headers)->assertOk();
});

test('admin update service', function () {
    $service = Service::factory()->create();
    $this->putJson("/api/admin/services/{$service->id}", ['title' => 'Updated'], $this->headers)->assertOk();
});

test('admin delete service', function () {
    $service = Service::factory()->create();
    $this->deleteJson("/api/admin/services/{$service->id}", [], $this->headers)->assertNoContent();
});

// User management
test('admin list users', function () {
    $this->getJson('/api/admin/users', $this->headers)->assertOk();
});

test('admin create user', function () {
    $this->postJson('/api/admin/users', [
        'username' => 'newadmin',
        'name' => 'New Admin',
        'email' => 'new@admin.com',
        'password' => '123456',
    ], $this->headers)->assertCreated();
});

test('admin cant delete self', function () {
    $this->deleteJson("/api/admin/users/{$this->user->id}", [], $this->headers)->assertStatus(409);
});

test('admin get me', function () {
    $this->getJson('/api/admin/users/me', $this->headers)->assertOk()->assertJsonFragment(['username' => 'admin']);
});

test('admin update password', function () {
    $this->putJson('/api/admin/users/me/password', [
        'current_password' => 'gta2026',
        'new_password' => 'nova123',
    ], $this->headers)->assertOk();
});

// Contact management
test('admin list contacts', function () {
    Contact::factory()->count(3)->create();
    $this->getJson('/api/admin/contacts', $this->headers)->assertOk()->assertJsonCount(3);
});

test('admin delete contact', function () {
    $contact = Contact::factory()->create();
    $this->deleteJson("/api/admin/contacts/{$contact->id}", [], $this->headers)->assertNoContent();
});

// Upload
test('admin upload image', function () {
    $file = UploadedFile::fake()->image('test.jpg', 100, 100);
    $this->postJson('/api/admin/upload', ['file' => $file], $this->headers)->assertCreated();
});

// Unauthenticated
test('admin endpoints require auth', function () {
    $this->getJson('/api/admin/services')->assertUnauthorized();
});

test('admin create product', function () {
    $data = Product::factory()->make(['image' => 'products/test.png'])->toArray();
    $this->postJson('/api/admin/products', $data, $this->headers)->assertCreated();
});

test('admin create testimonial', function () {
    $data = Testimonial::factory()->make(['avatar' => 'avatars/test.png'])->toArray();
    $this->postJson('/api/admin/testimonials', $data, $this->headers)->assertCreated();
});

test('admin create faq', function () {
    $data = Faq::factory()->make()->toArray();
    $this->postJson('/api/admin/faqs', $data, $this->headers)->assertCreated();
});

test('admin create brand', function () {
    $data = Brand::factory()->make(['logo' => 'brands/test.svg'])->toArray();
    $this->postJson('/api/admin/brands', $data, $this->headers)->assertCreated();
});

test('admin create process step', function () {
    $data = ProcessStep::factory()->make()->toArray();
    $this->postJson('/api/admin/process', $data, $this->headers)->assertCreated();
});

test('admin create estimator device', function () {
    $data = EstimatorDevice::factory()->make()->toArray();
    $this->postJson('/api/admin/estimator/devices', $data, $this->headers)->assertCreated();
});

test('admin create estimator issue', function () {
    $device = EstimatorDevice::factory()->create();
    $data = EstimatorIssue::factory()->make(['device_id' => $device->id])->toArray();
    $this->postJson('/api/admin/estimator/issues', $data, $this->headers)->assertCreated();
});

test('admin update business info', function () {
    BusinessInfo::factory()->create();
    $this->putJson('/api/admin/info', ['company_name' => 'Updated'], $this->headers)->assertOk();
});
