<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
            'features' => ['nullable', 'array'],
            'price_range' => ['sometimes', 'string', 'max:100'],
            'avg_time' => ['sometimes', 'string', 'max:100'],
        ];
    }
}
