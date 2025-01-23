<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Gère la connexion de l'utilisateur.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Valider les données de la requête
        $credentials = $request->only('email', 'password');

        // Tenter de connecter l'utilisateur
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->accessToken;

            // Retourner une réponse JSON de succès
            return response()->json([
                'status' => 'success',
                'message' => 'Action terminée avec succès',
                'data' => [
                    'api_access_token' => $token,
                ],
            ]);
        }

        // Retourner une réponse JSON d'erreur
        return response()->json([
            'status' => 'error',
            'message' => 'Non autorisé',
        ], 401);
    }
}