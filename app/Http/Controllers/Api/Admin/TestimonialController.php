<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTestimonialRequest;
use App\Http\Requests\Api\UpdateTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Testimonial::latest()->paginate(12));
    }

    public function show(Testimonial $testimonial): JsonResponse
    {
        return response()->json($testimonial);
    }

    public function store(StoreTestimonialRequest $request): JsonResponse
    {
        $testimonial = Testimonial::create($request->validated());

        return response()->json($testimonial, 201);
    }

    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial): JsonResponse
    {
        $testimonial->update($request->validated());

        return response()->json($testimonial);
    }

    public function destroy(Testimonial $testimonial): JsonResponse
    {
        $testimonial->delete();

        return response()->json(null, 204);
    }
}
