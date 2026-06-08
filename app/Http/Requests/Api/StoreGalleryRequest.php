<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'category' => ['sometimes', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'boolean'],
        ];
    }
}
