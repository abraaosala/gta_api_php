<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreEstimatorDeviceRequest;
use App\Http\Requests\Api\UpdateEstimatorDeviceRequest;
use App\Models\EstimatorDevice;
use Illuminate\Http\JsonResponse;

class EstimatorDeviceController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(EstimatorDevice::latest()->paginate(12));
    }

    public function show(EstimatorDevice $estimatorDevice): JsonResponse
    {
        return response()->json($estimatorDevice);
    }

    public function store(StoreEstimatorDeviceRequest $request): JsonResponse
    {
        $device = EstimatorDevice::create($request->validated());

        return response()->json($device, 201);
    }

    public function update(UpdateEstimatorDeviceRequest $request, EstimatorDevice $estimatorDevice): JsonResponse
    {
        $estimatorDevice->update($request->validated());

        return response()->json($estimatorDevice);
    }

    public function destroy(EstimatorDevice $estimatorDevice): JsonResponse
    {
        $estimatorDevice->delete();

        return response()->json(null, 204);
    }
}
