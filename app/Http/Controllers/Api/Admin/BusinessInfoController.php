<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateBusinessInfoRequest;
use App\Models\BusinessInfo;
use Illuminate\Http\JsonResponse;

class BusinessInfoController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json(BusinessInfo::findOrFail('main'));
    }

    public function update(UpdateBusinessInfoRequest $request): JsonResponse
    {
        $info = BusinessInfo::findOrFail('main');
        $info->update($request->validated());

        return response()->json($info);
    }
}
