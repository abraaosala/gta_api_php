<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProcessStepRequest;
use App\Http\Requests\Api\UpdateProcessStepRequest;
use App\Models\ProcessStep;
use Illuminate\Http\JsonResponse;

class ProcessStepController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ProcessStep::all());
    }

    public function show(ProcessStep $processStep): JsonResponse
    {
        return response()->json($processStep);
    }

    public function store(StoreProcessStepRequest $request): JsonResponse
    {
        $processStep = ProcessStep::create($request->validated());

        return response()->json($processStep, 201);
    }

    public function update(UpdateProcessStepRequest $request, ProcessStep $processStep): JsonResponse
    {
        $processStep->update($request->validated());

        return response()->json($processStep);
    }

    public function destroy(ProcessStep $processStep): JsonResponse
    {
        $processStep->delete();

        return response()->json(null, 204);
    }
}
