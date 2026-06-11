<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\EstimatorIssue;
use Illuminate\Http\JsonResponse;

class EstimatorIssueController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(EstimatorIssue::all());
    }

    public function show(EstimatorIssue $estimatorIssue): JsonResponse
    {
        return response()->json($estimatorIssue);
    }
}
