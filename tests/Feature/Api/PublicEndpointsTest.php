<?php

use App\Models\Brand;
use App\Models\BusinessInfo;
use App\Models\EstimatorDevice;
use App\Models\EstimatorIssue;
use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Service::factory()->count(3)->create();
    Product::factory()->count(3)->create();
    Testimonial::factory()->count(3)->create();
    Faq::factory()->count(3)->create();
    Brand::factory()->count(3)->create();
    ProcessStep::factory()->count(3)->create();
    BusinessInfo::factory()->create(['id' => 'main']);

    $device = EstimatorDevice::factory()->create();
    EstimatorIssue::factory()->count(2)->create(['device_id' => $device->id]);
});

test('landing exposes services', function () {
    $this->getJson('/api/public/landing')
        ->assertOk()
        ->assertJsonCount(3, 'services')
        ->assertJsonStructure(['services' => [['id', 'title']]]);
});

test('landing exposes products', function () {
    $this->getJson('/api/public/landing')
        ->assertOk()
        ->assertJsonCount(3, 'products')
        ->assertJsonStructure(['products' => [['id', 'name']]]);
});

test('landing exposes testimonials', function () {
    $this->getJson('/api/public/landing')
        ->assertOk()
        ->assertJsonCount(3, 'testimonials')
        ->assertJsonStructure(['testimonials' => [['id', 'name']]]);
});

test('landing exposes faqs', function () {
    $this->getJson('/api/public/landing')
        ->assertOk()
        ->assertJsonCount(3, 'faqs')
        ->assertJsonStructure(['faqs' => [['id', 'question']]]);
});

test('landing exposes brands', function () {
    $this->getJson('/api/public/landing')
        ->assertOk()
        ->assertJsonCount(3, 'brands')
        ->assertJsonStructure(['brands' => [['id', 'name']]]);
});

test('landing exposes process steps', function () {
    $this->getJson('/api/public/landing')
        ->assertOk()
        ->assertJsonCount(3, 'process')
        ->assertJsonStructure(['process' => [['id', 'title']]]);
});

test('landing exposes estimator devices with issues', function () {
    $this->getJson('/api/public/landing')
        ->assertOk()
        ->assertJsonCount(1, 'estimator')
        ->assertJsonStructure(['estimator' => [['id', 'name', 'issues']]]);
});

test('landing exposes business info', function () {
    $this->getJson('/api/public/landing')->assertOk()->assertJsonStructure(['info']);
});

test('store contact with valid data', function () {
    $this->postJson('/api/public/contacts', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+244123456789',
        'message' => 'Preciso de ajuda com o meu telemóvel.',
    ])->assertCreated();

    $this->assertDatabaseHas('contacts', ['email' => 'john@example.com']);
});

test('store contact without name returns 422', function () {
    $this->postJson('/api/public/contacts', [
        'email' => 'john@example.com',
        'message' => 'Olá',
    ])->assertUnprocessable();
});

test('store contact without email returns 422', function () {
    $this->postJson('/api/public/contacts', [
        'name' => 'John',
        'message' => 'Olá',
    ])->assertUnprocessable();
});
