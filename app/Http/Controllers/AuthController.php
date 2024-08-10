<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Valida as credenciais recebidas
        $credenciais = $request->only('email', 'password');

        // Tenta autenticar o usuário
        if (!$token = auth('api')->attempt($credenciais)) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60 // Tempo de expiração em segundos
        ]);

    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function refresh()
    {
        return response()->json(['access_token' => auth('api')->refresh()], 200);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Sessão encerrada com sucesso']);
    }
}
