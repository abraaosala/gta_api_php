<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstimatorIssueRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'device_id' => ['required', 'exists:estimator_devices,id'],
            'name' => ['required', 'string', 'max:255'],
            'price_multiplier' => ['required', 'numeric', 'min:0'],
        ];
    }
}
