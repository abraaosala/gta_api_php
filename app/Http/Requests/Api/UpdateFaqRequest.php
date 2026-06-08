<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'question' => ['sometimes', 'string'],
            'answer' => ['sometimes', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
