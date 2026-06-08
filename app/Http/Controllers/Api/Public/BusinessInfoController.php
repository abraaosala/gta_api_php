<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Public\BusinessInfoResource;
use App\Models\BusinessInfo;

class BusinessInfoController extends Controller
{
    public function show(): BusinessInfoResource
    {
        return new BusinessInfoResource(BusinessInfo::findOrFail('main'));
    }
}
