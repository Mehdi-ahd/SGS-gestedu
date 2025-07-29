<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KKiaPayService
{
    private $publicKey;
    private $privateKey;
    private $secretKey;
    private $baseUrl;

    public function __construct()
    {
        $this->publicKey = config('kkiapay.public_key');
        $this->privateKey = config('kkiapay.private_key');
        $this->secretKey = config('kkiapay.secret_key');
        $this->baseUrl = config('kkiapay.sandbox') 
            ? 'https://api-sandbox.kkiapay.me' 
            : 'https://api.kkiapay.me';
    }

    /**
     * Initier un paiement
     */
    public function initiatePayment($amount, $reason, $webhook = null, $data = [])
    {
        try {
            $response = Http::withHeaders([
                'X-API-KEY' => $this->privateKey,
                'Content-Type' => 'application/json'
            ])->post($this->baseUrl . '/v1/transactions/initialize', [
                'amount' => $amount,
                'currency' => 'XOF', // Franc CFA
                'reason' => $reason,
                'webhook' => $webhook ?? config('kkiapay.webhook_url'),
                'data' => $data
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => 'Erreur lors de l\'initialisation du paiement',
                'error' => $response->json()
            ];

        } catch (\Exception $e) {
            Log::error('KKiaPay initiate payment error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur de connexion au service de paiement'
            ];
        }
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function verifyPayment($transactionId)
    {
        try {
            $response = Http::withHeaders([
                'X-API-KEY' => $this->privateKey
            ])->get($this->baseUrl . "/v1/transactions/{$transactionId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => 'Transaction non trouvée'
            ];

        } catch (\Exception $e) {
            Log::error('KKiaPay verify payment error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors de la vérification'
            ];
        }
    }

    /**
     * Générer l'URL de paiement
     */
    public function generatePaymentUrl($amount, $reason, $callback = null, $data = [])
    {
        $params = [
            'amount' => $amount,
            'reason' => $reason,
            'key' => $this->publicKey,
            'callback' => $callback
        ];

        if (!empty($data)) {
            $params['data'] = json_encode($data);
        }

        $basePaymentUrl = config('kkiapay.sandbox') 
            ? 'https://widget-sandbox.kkiapay.me' 
            : 'https://widget.kkiapay.me';

        return $basePaymentUrl . '?' . http_build_query($params);
    }

    /**
     * Valider la signature webhook
     */
    public function validateWebhookSignature($payload, $signature)
    {
        $expectedSignature = hash_hmac('sha256', $payload, $this->secretKey);
        return hash_equals($expectedSignature, $signature);
    }
}
