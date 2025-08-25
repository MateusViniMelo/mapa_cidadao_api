<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:100',
            'email'    => 'required|email:rfc,dns|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&^()\-_=+])[A-Za-z\d@$!%*#?&^()\-_=+]{8,}$/',
            ],
            'date_birth' => [
                'required',
                'date',
                'before_or_equal:'.now()->subYears(18)->format('Y-m-d'),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'       => 'Nome',
            'email'      => 'E-mail',
            'password'   => 'Senha',
            'date_birth' => 'Data de Nascimento',
        ];
    }

    public function messages(): array
    {
        return [
            'password.confirmed'         => 'A confirmação da senha não corresponde.',
            'password.regex'             => 'A senha deve conter pelo menos uma letra maiúscula, uma minúscula, um número e um caractere especial.',
            'email.email'                => 'O e-mail informado não é válido ou o domínio não existe.',
            'date_birth.before_or_equal' => 'Você deve ter pelo menos 18 anos.',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Nome completo do usuário (máximo 100 caracteres).',
                'example'     => 'João da Silva',
            ],
            'email' => [
                'description' => 'E-mail válido e único.',
                'example'     => 'joao@email.com',
            ],
            'password' => [
                'description' => 'Senha com no mínimo 8 caracteres, contendo ao menos uma letra maiúscula, uma minúscula, um número e um caractere especial.',
                'example'     => 'SenhaForte@123',
            ],
            'password_confirmation' => [
                'description' => 'Confirmação da senha (deve ser igual à senha).',
                'example'     => 'SenhaForte@123',
            ],
            'date_birth' => [
                'description' => 'Data de nascimento no formato YYYY-MM-DD. Deve ser anterior ou igual à data atual menos 18 anos.',
                'example'     => '1990-05-21',
            ],
        ];
    }
}
