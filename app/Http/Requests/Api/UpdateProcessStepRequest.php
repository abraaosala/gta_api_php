<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProcessStepRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'step' => ['sometimes', 'integer', 'min:1'],
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
        ];
    }
}
