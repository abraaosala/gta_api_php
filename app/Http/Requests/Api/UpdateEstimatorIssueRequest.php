<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstimatorIssueRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'device_id' => ['sometimes', 'exists:estimator_devices,id'],
            'name' => ['sometimes', 'string', 'max:255'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'estimated_time' => ['nullable', 'string', 'max:100'],
            'price_multiplier' => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
