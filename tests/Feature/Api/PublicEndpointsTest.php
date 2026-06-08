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

test('list services', function () {
    $this->getJson('/api/public/services')->assertOk()->assertJsonCount(3, 'data');
});

test('show service', function () {
    $service = Service::first();
    $this->getJson("/api/public/services/{$service->id}")
        ->assertOk()
        ->assertJsonStructure(['data' => ['id', 'title']]);
});

test('show service not found returns 404', function () {
    $this->getJson('/api/public/services/99999')->assertNotFound();
});

test('list products', function () {
    $this->getJson('/api/public/products')->assertOk()->assertJsonCount(3, 'data');
});

test('show product', function () {
    $product = Product::first();
    $this->getJson("/api/public/products/{$product->id}")
        ->assertOk()
        ->assertJsonStructure(['data' => ['id', 'name']]);
});

test('list testimonials', function () {
    $this->getJson('/api/public/testimonials')->assertOk()->assertJsonCount(3, 'data');
});

test('show testimonial', function () {
    $testimonial = Testimonial::first();
    $this->getJson("/api/public/testimonials/{$testimonial->id}")
        ->assertOk()
        ->assertJsonStructure(['data' => ['id', 'name']]);
});

test('list faqs', function () {
    $this->getJson('/api/public/faqs')->assertOk()->assertJsonCount(3, 'data');
});

test('show faq', function () {
    $faq = Faq::first();
    $this->getJson("/api/public/faqs/{$faq->id}")
        ->assertOk()
        ->assertJsonStructure(['data' => ['id', 'question']]);
});

test('list brands', function () {
    $this->getJson('/api/public/brands')->assertOk()->assertJsonCount(3, 'data');
});

test('show brand', function () {
    $brand = Brand::first();
    $this->getJson("/api/public/brands/{$brand->id}")
        ->assertOk()
        ->assertJsonStructure(['data' => ['id', 'name']]);
});

test('list process steps', function () {
    $this->getJson('/api/public/process')->assertOk()->assertJsonCount(3, 'data');
});

test('show process step', function () {
    $step = ProcessStep::first();
    $this->getJson("/api/public/process/{$step->id}")
        ->assertOk()
        ->assertJsonStructure(['data' => ['id', 'title']]);
});

test('list estimator devices with issues', function () {
    $this->getJson('/api/public/estimator/devices')
        ->assertOk()
        ->assertJsonStructure(['data' => [['id', 'name', 'issues']]]);
});

test('show estimator device with issues', function () {
    $device = EstimatorDevice::with('issues')->first();
    $this->getJson("/api/public/estimator/devices/{$device->id}")
        ->assertOk()
        ->assertJsonStructure(['data' => ['id', 'name', 'issues']]);
});

test('show business info', function () {
    $this->getJson('/api/public/info')->assertOk();
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
