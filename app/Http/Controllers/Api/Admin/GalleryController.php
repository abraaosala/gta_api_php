<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreGalleryRequest;
use App\Http\Requests\Api\UpdateGalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\JsonResponse;

class GalleryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Gallery::orderBy('sort_order')->paginate(12));
    }

    public function show(Gallery $gallery): JsonResponse
    {
        return response()->json($gallery);
    }

    public function store(StoreGalleryRequest $request): JsonResponse
    {
        $gallery = Gallery::create($request->validated());

        return response()->json($gallery, 201);
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery): JsonResponse
    {
        $gallery->update($request->validated());

        return response()->json($gallery);
    }

    public function destroy(Gallery $gallery): JsonResponse
    {
        $gallery->delete();

        return response()->json(null, 204);
    }
}
