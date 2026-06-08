<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'O campo usuário é obrigatório.',
            'password.required' => 'O campo senha é obrigatório.',
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => 'usuário',
            'password' => 'senha',
        ];
    }
}
