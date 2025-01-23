<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panic;
use App\Jobs\SendPanicToWayneEnterprises;
use App\Jobs\CancelPanicInWayneEnterprises;
use Illuminate\Support\Facades\Auth;

class PanicController extends Controller
{
    /**
     * Envoyer une panique.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendPanic(Request $request)
    {
        // Validation des données de la requête
        $request->validate([
            'longitude' => 'required|string',
            'latitude' => 'required|string',
            'panic_type' => 'nullable|string',
            'details' => 'nullable|string',
        ]);

        // Créer une nouvelle panique dans la base de données
        $panic = Panic::create([
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'panic_type' => $request->panic_type,
            'details' => $request->details,
            'user_id' => Auth::id(), // Associer la panique à l'utilisateur connecté
        ]);

        // Envoyer la panique à Wayne Enterprises via une queue
        dispatch(new SendPanicToWayneEnterprises($panic));

        // Retourner une réponse JSON de succès
        return response()->json([
            'status' => 'success',
            'message' => 'Panique déclenchée avec succès',
            'data' => [
                'panic_id' => $panic->id,
            ],
        ]);
    }

    /**
     * Annuler une panique.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelPanic(Request $request)
    {
        // Validation des données de la requête
        $request->validate([
            'panic_id' => 'required|integer',
        ]);

        // Trouver la panique par son ID
        $panic = Panic::find($request->panic_id);

        // Vérifier si la panique existe
        if (!$panic) {
            return response()->json([
                'status' => 'error',
                'message' => 'Panique non trouvée',
            ], 400);
        }

        // Annuler la panique dans Wayne Enterprises via une queue
        dispatch(new CancelPanicInWayneEnterprises($panic));

        // Supprimer la panique de la base de données
        $panic->delete();

        // Retourner une réponse JSON de succès
        return response()->json([
            'status' => 'success',
            'message' => 'Panique annulée avec succès',
            'data' => [],
        ]);
    }

    /**
     * Obtenir l'historique des paniques.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPanicHistory()
    {
        // Récupérer toutes les paniques avec les informations de l'utilisateur
        $panics = Panic::with('user')->get();

        // Retourner une réponse JSON avec l'historique des paniques
        return response()->json([
            'status' => 'success',
            'message' => 'Action terminée avec succès',
            'data' => [
                'panics' => $panics,
            ],
        ]);
    }
}