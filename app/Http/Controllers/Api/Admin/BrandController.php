<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBrandRequest;
use App\Http\Requests\Api\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Brand::latest()->paginate(12));
    }

    public function show(Brand $brand): JsonResponse
    {
        return response()->json($brand);
    }

    public function store(StoreBrandRequest $request): JsonResponse
    {
        $brand = Brand::create($request->validated());

        return response()->json($brand, 201);
    }

    public function update(UpdateBrandRequest $request, Brand $brand): JsonResponse
    {
        $brand->update($request->validated());

        return response()->json($brand);
    }

    public function destroy(Brand $brand): JsonResponse
    {
        $brand->delete();

        return response()->json(null, 204);
    }
}
