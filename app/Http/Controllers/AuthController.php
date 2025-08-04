<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @group Autenticação
     * Autenticar usuário e retornar token de acesso.
     *
     * Este endpoint permite que o usuário realize login com e-mail e senha válidos.
     *
     * @response 200 {
     *  "user": {
     *    "id": 1,
     *    "name": "João Silva",
     *    "email": "user@email.com",
     *     "date_birth": "2002-02-01",
     *    "created_at": "2025-07-10T19:00:00.000000Z",
     *    "updated_at": "2025-07-10T19:00:00.000000Z"
     *  },
     *  "token": "1|XyzAbc123..."
     * }
     * @response 401 {
     *  "message": "Credenciais inválidas"
     * }
     */
    public function login(LoginUserRequest $request): JsonResponse
    {

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user['password'])) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    /**
     * @group Autenticação
     * Retornar informações do usuário autenticado.
     *
     * Este endpoint retorna os dados do usuário logado e um novo token de acesso.
     *
     * @authenticated
     *
     * @response 200 {
     *  "user": {
     *    "id": 1,
     *    "name": "João Silva",
     *    "email": "user@email.com",
     *     "date_birth": "2002-02-01",
     *    "created_at": "2025-07-10T19:00:00.000000Z",
     *    "updated_at": "2025-07-10T19:00:00.000000Z"
     *  },
     *  "token": "1|XyzAbc123..."
     * }
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    /**
     * @group Autenticação
     * Fazer logout do usuário autenticado.
     *
     * Este endpoint revoga o token de acesso atual do usuário.
     *
     * @authenticated
     *
     * @response 200 {
     *  "message": "Logout realizado com sucesso"
     * }
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
}
