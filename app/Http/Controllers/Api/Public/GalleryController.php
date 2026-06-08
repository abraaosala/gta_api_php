<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Public\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GalleryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return GalleryResource::collection(
            Gallery::where('active', true)->orderBy('sort_order')->get()
        );
    }
}
