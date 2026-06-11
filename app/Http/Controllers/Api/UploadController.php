<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:jpeg,png,webp,gif', 'max:5120'],
        ], [
            'file.required' => 'Nenhum ficheiro enviado.',
            'file.file' => 'O ficheiro enviado é inválido.',
            'file.mimes' => 'Formato não suportado. Use JPEG, PNG, WebP ou GIF.',
            'file.max' => 'Ficheiro muito grande. O limite é 5MB.',
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        return response()->json([
            'url' => url("storage/$path"),
        ], 201);
    }
}
