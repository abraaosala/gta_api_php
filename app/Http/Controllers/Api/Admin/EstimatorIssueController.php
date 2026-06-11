<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreEstimatorIssueRequest;
use App\Http\Requests\Api\UpdateEstimatorIssueRequest;
use App\Models\EstimatorIssue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EstimatorIssueController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = EstimatorIssue::latest();

        if ($request->filled('device_id')) {
            $query->where('device_id', $request->device_id);
        }

        return response()->json($query->paginate(12));
    }

    public function show(EstimatorIssue $estimatorIssue): JsonResponse
    {
        return response()->json($estimatorIssue);
    }

    public function store(StoreEstimatorIssueRequest $request): JsonResponse
    {
        $issue = EstimatorIssue::create($request->validated());

        return response()->json($issue, 201);
    }

    public function update(UpdateEstimatorIssueRequest $request, EstimatorIssue $estimatorIssue): JsonResponse
    {
        $estimatorIssue->update($request->validated());

        return response()->json($estimatorIssue);
    }

    public function destroy(EstimatorIssue $estimatorIssue): JsonResponse
    {
        $estimatorIssue->delete();

        return response()->json(null, 204);
    }
}
