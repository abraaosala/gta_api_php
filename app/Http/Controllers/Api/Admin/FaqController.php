<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreFaqRequest;
use App\Http\Requests\Api\UpdateFaqRequest;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;

class FaqController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Faq::latest()->paginate(12));
    }

    public function show(Faq $faq): JsonResponse
    {
        return response()->json($faq);
    }

    public function store(StoreFaqRequest $request): JsonResponse
    {
        $faq = Faq::create($request->validated());

        return response()->json($faq, 201);
    }

    public function update(UpdateFaqRequest $request, Faq $faq): JsonResponse
    {
        $faq->update($request->validated());

        return response()->json($faq);
    }

    public function destroy(Faq $faq): JsonResponse
    {
        $faq->delete();

        return response()->json(null, 204);
    }
}
