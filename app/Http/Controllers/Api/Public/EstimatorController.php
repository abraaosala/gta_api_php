<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Public\EstimatorDeviceResource;
use App\Models\EstimatorDevice;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EstimatorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return EstimatorDeviceResource::collection(
            EstimatorDevice::with('issues')->get()
        );
    }

    public function show(EstimatorDevice $estimatorDevice): EstimatorDeviceResource
    {
        $estimatorDevice->load('issues');

        return new EstimatorDeviceResource($estimatorDevice);
    }
}
