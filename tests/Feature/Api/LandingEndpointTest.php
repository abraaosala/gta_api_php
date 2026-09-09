<?php

use App\Models\Brand;
use App\Models\BusinessInfo;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\Service;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('landing endpoint returns all data', function () {
    BusinessInfo::factory()->create(['id' => 'main']);
    Service::factory()->count(2)->create();
    Product::factory()->count(2)->create();
    Testimonial::factory()->count(2)->create();
    Faq::factory()->count(2)->create();
    Brand::factory()->count(2)->create();
    ProcessStep::factory()->count(2)->create();
    Feature::factory()->count(2)->create(['active' => true]);
    Gallery::factory()->count(2)->create(['active' => true]);
    Team::factory()->count(2)->create(['active' => true]);

    $response = $this->getJson('/api/public/landing');

    $response->assertOk();
    $response->assertJsonStructure([
        'info', 'services', 'products', 'testimonials', 'faqs',
        'brands', 'process', 'features', 'team', 'gallery',
    ]);
});

test('landing only exposes active features, team and gallery', function () {
    BusinessInfo::factory()->create(['id' => 'main']);
    Feature::factory()->count(2)->create(['active' => true]);
    Feature::factory()->create(['active' => false]);
    Team::factory()->count(2)->create(['active' => true]);
    Team::factory()->create(['active' => false]);
    Gallery::factory()->count(2)->create(['active' => true]);
    Gallery::factory()->create(['active' => false]);

    $response = $this->getJson('/api/public/landing');

    $response->assertOk();
    $response->assertJsonCount(2, 'features');
    $response->assertJsonCount(2, 'team');
    $response->assertJsonCount(2, 'gallery');
});
