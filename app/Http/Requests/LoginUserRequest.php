<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'    => 'required|email',
            'password' => 'required',
        ];
    }

    public function attributes(): array
    {

        return [
            'password' => 'senha',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'email' => [
                'description' => 'E-mail do usuário para login.',
                'example'     => 'usuario@email.com',
            ],
            'password' => [
                'description' => 'Senha do usuário.',
                'example'     => 'SenhaForte@123',
            ],
        ];
    }
}
