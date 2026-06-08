<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreFeatureRequest;
use App\Http\Requests\Api\UpdateFeatureRequest;
use App\Models\Feature;
use Illuminate\Http\JsonResponse;

class FeatureController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Feature::orderBy('sort_order')->get());
    }

    public function show(Feature $feature): JsonResponse
    {
        return response()->json($feature);
    }

    public function store(StoreFeatureRequest $request): JsonResponse
    {
        $feature = Feature::create($request->validated());

        return response()->json($feature, 201);
    }

    public function update(UpdateFeatureRequest $request, Feature $feature): JsonResponse
    {
        $feature->update($request->validated());

        return response()->json($feature);
    }

    public function destroy(Feature $feature): JsonResponse
    {
        $feature->delete();

        return response()->json(null, 204);
    }
}
