<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Inscription;
use App\Models\Tuition;
use App\Models\YearSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ParentPaymentController extends Controller
{
    /**
     * Afficher la page des paiements pour les parents
     */
    public function index()
    {
        $currentYear = date("Y") . "-" . (date("Y") + 1);

        // Obtenir les inscriptions des enfants du parent connecté
        $inscriptions = Inscription::with(['student', 'study_level'])
            ->where('school_year_id', $currentYear)
            ->where('status', 'accepté')
            ->whereHas('student.supervisors', function($query) {
                $query->where('supervisor_id', Auth::id());
            })
            ->get();

        return view('parent.payments.index', compact('inscriptions'));
    }

    /**
     * Obtenir les frais disponibles pour une inscription (AJAX)
     */
    public function getAvailableFees($inscriptionId)
    {
        // Vérifier que l'inscription appartient bien à un enfant du parent connecté
        $inscription = Inscription::with(['student', 'study_level'])
            ->whereHas('student.supervisors', function($query) {
                $query->where('supervisor_id', Auth::id());
            })
            ->findOrFail($inscriptionId);

        $availableFees = $this->calculateAvailableFees($inscription);

        return response()->json([
            'success' => true,
            'fees' => $availableFees
        ]);
    }

    /**
     * Initier un paiement avec KKiaPay
     */
    public function initiatePayment(Request $request)
    {
        $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'tuition_id' => 'required|exists:tuitions,id',
            'amount' => 'required|numeric|min:0'
        ]);

        // Vérifier que l'inscription appartient au parent connecté
        $inscription = Inscription::whereHas('student.supervisors', function($query) {
            $query->where('supervisor_id', Auth::id());
        })->findOrFail($request->inscription_id);

        $tuition = Tuition::findOrFail($request->tuition_id);

        // Vérifier que le paiement est autorisé
        $availableFees = $this->calculateAvailableFees($inscription);
        $selectedFee = collect($availableFees)->firstWhere('tuition_id', $request->tuition_id);

        if (!$selectedFee || !$selectedFee['can_pay']) {
            return response()->json([
                'success' => false,
                'message' => 'Ce frais ne peut pas être payé pour le moment'
            ], 400);
        }

        // Ici vous intégrerez l'API KKiaPay
        // Pour l'instant, on simule le succès
        try {
            // Simulation d'intégration KKiaPay
            $paymentData = [
                'amount' => $request->amount,
                'currency' => 'XOF',
                'description' => $tuition->motif . ' - ' . $inscription->student->getFullName(),
                'callback_url' => route('parent.payments.callback'),
                'return_url' => route('parent.payments.success'),
                'customer' => [
                    'name' => Auth::user()->getFullName(),
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone
                ]
            ];

            // TODO: Intégrer l'API KKiaPay ici
            // $kkiapayResponse = $this->callKKiaPayAPI($paymentData);

            return response()->json([
                'success' => true,
                'message' => 'Redirection vers la page de paiement...',
                'payment_url' => '#', // URL de paiement KKiaPay
                'payment_data' => $paymentData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'initiation du paiement'
            ], 500);
        }
    }

    /**
     * Callback de confirmation de paiement KKiaPay
     */
    public function paymentCallback(Request $request)
    {
        // TODO: Traiter le callback de KKiaPay
        // Vérifier la signature, enregistrer le paiement, etc.

        return response()->json(['status' => 'success']);
    }

    /**
     * Page de succès après paiement
     */
    public function paymentSuccess(Request $request)
    {
        return view('parent.payments.success');
    }

    /**
     * Historique des paiements
     */
    public function history()
    {
        $payments = Bill::with(['inscription.student', 'tuitions'])
            ->whereHas('inscription.student.supervisors', function($query) {
                $query->where('supervisor_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('parent.payments.history', compact('payments'));
    }

    /**
     * Calculer les frais disponibles pour une inscription
     */
    private function calculateAvailableFees($inscription)
    {
        $availableFees = [];

        // Obtenir tous les frais pour ce niveau d'étude
        $tuitions = Tuition::where('study_level_id', $inscription->study_level_id)->get();

        // Vérifier si l'élève avait une inscription l'année précédente
        $hadPreviousEnrollment = $this->checkPreviousEnrollment($inscription->id);

        foreach ($tuitions as $tuition) {
            $canPay = false;
            $paymentStep = 1;

            // Logique de priorité des paiements
            if ($tuition->type === 'inscription' && !$hadPreviousEnrollment) {
                $canPay = $this->checkNoPaymentsExist($inscription->id);
            } elseif ($tuition->type === 'réinscription' && $hadPreviousEnrollment) {
                $canPay = $this->checkNoPaymentsExist($inscription->id);
            } elseif ($tuition->type === 'scolarité') {
                // Vérifier les paiements par trimestre
                $trimesterInfo = $this->checkTrimesterPayments($inscription->id, $tuition->id);
                $canPay = $trimesterInfo['can_pay'];
                $paymentStep = $trimesterInfo['step'];
            }

            if ($canPay) {
                $availableFees[] = [
                    'tuition_id' => $tuition->id,
                    'motif' => $tuition->motif,
                    'type' => $tuition->type,
                    'amount' => $tuition->amount,
                    'payment_step' => $paymentStep,
                    'can_pay' => true
                ];
            }
        }
        return $availableFees;
    }

    /**
     * Vérifier si l'élève avait une inscription l'année précédente
     */
    private function checkPreviousEnrollment($inscriptionId)
    {
        $currentInscription = Inscription::findOrFail($inscriptionId);
        $previousYear = (date("Y") - 1) . "-" . date("Y");

        return Inscription::where('student_id', $currentInscription->student_id)
            ->where('school_year_id', $previousYear)
            ->where('status', 'achevé')
            ->exists();
    }

    /**
     * Vérifier qu'aucun paiement n'existe pour cette inscription
     */
    private function checkNoPaymentsExist($inscriptionId)
    {
        return !Bill::where('inscription_id', $inscriptionId)->exists();
    }

    /**
     * Vérifier les paiements par trimestre
     */
    private function checkTrimesterPayments($inscriptionId, $tuitionId)
    {
        // Obtenir tous les trimestres triés par ID
        $yearSessions = YearSession::orderBy('id')->get();

        foreach ($yearSessions as $index => $session) {
            $paymentExists = Bill::where('inscription_id', $inscriptionId)
                ->where('tuition_id', $tuitionId)
                ->where('payment_step', $index + 1)
                ->exists();

            if (!$paymentExists) {
                return [
                    'can_pay' => true,
                    'step' => $index + 1
                ];
            }
        }

        return [
            'can_pay' => false,
            'step' => null
        ];
    }

    /**
     * Vérifier une transaction KKiaPay
     */
    private function verifyKKiaPayTransaction($transactionId)
    {
        try {
            // Configuration pour le sandbox KKiaPay
            $apiKey = env('KKIAPAY_PRIVATE_KEY', 'test_private_key');
            $apiUrl = env('KKIAPAY_SANDBOX', true) ? 'https://api-sandbox.kkiapay.me' : 'https://api.kkiapay.me';

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json'
            ])->get($apiUrl . "/v1/transaction/" . $transactionId);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => $data['status'] === 'SUCCESS',
                    'data' => $data
                ];
            }

            return ['success' => false, 'data' => null];

        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

}