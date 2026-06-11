<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Product::latest()->paginate(12));
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        if (empty($data['image'])) {
            unset($data['image']);
        }
        $product = Product::create($data);

        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();
        if (empty($data['image'])) {
            unset($data['image']);
        }
        $product->update($data);

        return response()->json($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
