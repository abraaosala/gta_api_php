<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Public\BrandResource;
use App\Http\Resources\Public\BusinessInfoResource;
use App\Http\Resources\Public\FaqResource;
use App\Http\Resources\Public\FeatureResource;
use App\Http\Resources\Public\GalleryResource;
use App\Http\Resources\Public\ProcessStepResource;
use App\Http\Resources\Public\ProductResource;
use App\Http\Resources\Public\ServiceResource;
use App\Http\Resources\Public\TeamResource;
use App\Http\Resources\Public\TestimonialResource;
use App\Models\Brand;
use App\Models\BusinessInfo;
use App\Models\EstimatorDevice;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class LandingController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'info' => BusinessInfoResource::make(BusinessInfo::findOrFail('main')),
            'services' => ServiceResource::collection(Service::all()),
            'products' => ProductResource::collection(Product::all()),
            'testimonials' => TestimonialResource::collection(Testimonial::all()),
            'faqs' => FaqResource::collection(Faq::orderBy('sort_order')->get()),
            'brands' => BrandResource::collection(Brand::all()),
            'process' => ProcessStepResource::collection(ProcessStep::orderBy('step')->get()),
            'features' => FeatureResource::collection(Feature::where('active', true)->orderBy('sort_order')->get()),
            'team' => TeamResource::collection(Team::where('active', true)->orderBy('sort_order')->get()),
            'gallery' => GalleryResource::collection(Gallery::where('active', true)->orderBy('sort_order')->get()),
            'estimator' => EstimatorDevice::with('issues')->get()->map(fn ($device) => [
                'id' => $device->id,
                'name' => $device->name,
                'icon' => $device->icon,
                'base_price' => $device->base_price,
                'brands' => [],
                'issues' => $device->issues->map(fn ($issue) => [
                    'id' => $issue->id,
                    'name' => $issue->name,
                    'base_price' => $issue->base_price,
                    'price_multiplier' => $issue->price_multiplier,
                    'local_price' => $issue->local_price,
                    'estimated_time' => $issue->estimated_time,
                ]),
            ]),
            'settings' => Setting::pluck('value', 'key'),
        ]);
    }
}
