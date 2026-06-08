<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Public\FeatureResource;
use App\Models\Feature;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FeatureController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return FeatureResource::collection(
            Feature::where('active', true)->orderBy('sort_order')->get()
        );
    }
}
