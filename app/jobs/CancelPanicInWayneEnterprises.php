<?php 


namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Panic;

class CancelPanicInWayneEnterprises implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $panic;

    /**
     * Crée une nouvelle instance du job.
     *
     * @param Panic $panic
     */
    public function __construct(Panic $panic)
    {
        $this->panic = $panic;
    }

    /**
     * Exécute le job.
     */
    public function handle()
    {
        // Annuler la panique dans l'API Wayne Enterprises
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.wayne_enterprises.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://wayne.fusebox-staging.co.za/api/v1/panic/cancel', [
            'id' => $this->panic->id, // ID de la panique dans Wayne Enterprises
        ]);

        // Vérifier si la requête a échoué
        if ($response->failed()) {
            // Log l'échec et notifier l'administrateur
            Log::error('Échec de l\'annulation de la panique dans Wayne Enterprises', [
                'panic_id' => $this->panic->id,
                'response' => $response->json(),
            ]);
        } else {
            // Log la réussite
            Log::info('Panique annulée avec succès dans Wayne Enterprises', [
                'panic_id' => $this->panic->id,
                'response' => $response->json(),
            ]);
        }
    }
}