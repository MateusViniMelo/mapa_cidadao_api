<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * @group Cadastrar
     * Registrar novo usuário
     *
     * Este endpoint cria um novo usuário e retorna um token de autenticação.
     *
     * @response 201 {
     *   "user": {
     *     "id": 1,
     *     "name": "João da Silva",
     *     "email": "joao@email.com",
     *     "date_birth": "1990-05-21",
     *     "created_at": "2025-07-10T20:00:00.000000Z",
     *     "updated_at": "2025-07-10T20:00:00.000000Z"
     *   },
     *   "token": "1|abc123def456..."
     * }
     * @response 422 {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *     "password": [
     *       "A senha deve conter pelo menos uma letra maiúscula, uma minúscula, um número e um caractere especial.",
     *       "A confirmação da senha não corresponde."
     *     ]
     *   }
     * }
     */
    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'date_birth' => $data['date_birth'],
            'password'   => Hash::make($data['password']),

        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);

    }
}
