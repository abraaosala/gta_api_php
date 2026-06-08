<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Public\ProcessStepResource;
use App\Models\ProcessStep;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProcessStepController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProcessStepResource::collection(ProcessStep::all());
    }

    public function show(ProcessStep $processStep): ProcessStepResource
    {
        return new ProcessStepResource($processStep);
    }
}
