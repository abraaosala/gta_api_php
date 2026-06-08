<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
            'features' => ['nullable', 'array'],
            'price_range' => ['required', 'string', 'max:100'],
            'avg_time' => ['required', 'string', 'max:100'],
        ];
    }
}
