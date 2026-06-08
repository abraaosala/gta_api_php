<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreContactRequest;
use App\Services\Contracts\ContactServiceInterface;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function __construct(
        protected ContactServiceInterface $contactService,
    ) {}

    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = $this->contactService->store($request->validated());

        return response()->json($contact, 201);
    }
}
