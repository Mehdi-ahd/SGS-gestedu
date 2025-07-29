<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\YearSession;
use App\Models\Tuition;
use App\Models\Bill;
use App\Models\StudyLevel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ParentPaymentController extends Controller
{
    public function index()
    {
        return view('parent.payments.index');
    }

    public function getValidatedInscriptions(Request $request)
    {
        try {
            $currentYear = $request->get('year', date('Y') . '-' . (date('Y') + 1));
            $parentId = Auth::id();

            // Récupérer les inscriptions des enfants de ce parent avec statut "accepté"
            $inscriptions = Inscription::with([
                'student', 
                'study_level', 
                'group'
            ])
            ->whereHas('student.supervisors', function($query) use ($parentId) {
                $query->where('supervisor_id', $parentId);
            })
            ->where('school_year_id', $currentYear)
            ->where('status', 'accepté')
            ->get();

            // Ajouter les informations de paiement pour chaque inscription
            foreach ($inscriptions as $inscription) {
                // Vérifier si l'étudiant a des inscriptions précédentes achevées
                $inscription->student->has_previous_completed_inscription = 
                    Inscription::where('student_id', $inscription->student_id)
                        ->where('school_year_id', '<', $currentYear)
                        ->where('status', 'achevé')
                        ->exists();

                // Calculer le total des frais pour ce niveau d'étude
                $inscription->total_tuitions = Tuition::where('study_level_id', $inscription->study_level_id)
                    ->sum('amount');
            }

            return response()->json([
                'success' => true,
                'inscriptions' => $inscriptions
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des inscriptions : ' . $e->getMessage()
            ]);
        }
    }

    public function getPaymentDetails($inscriptionId)
    {
        try {
            $inscription = Inscription::with(['student', 'study_level', 'group'])
                ->findOrFail($inscriptionId);

            // Vérifier que cette inscription appartient au parent connecté
            $parentId = Auth::id();
            $isParentOfStudent = $inscription->student->supervisors()->where('supervisor_id', $parentId)->exists();
            
            if (!$isParentOfStudent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Accès non autorisé'
                ]);
            }

            // Obtenir toutes les sessions par ordre croissant d'ID
            $allSessions = YearSession::orderBy('id')->get();

            // Calculer le total payé pour cette inscription
            $totalPaid = Bill::where('inscription_id', $inscriptionId)->sum('amount_paid');

            // Trouver la session actuelle à payer
            $currentSession = $this->getCurrentPaymentSession($inscription->study_level_id, $totalPaid, $allSessions);

            if (!$currentSession) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tous les frais ont été payés'
                ]);
            }

            // Obtenir les frais pour la session actuelle
            $tuitions = Tuition::where('study_level_id', $inscription->study_level_id)
                ->where('year_session_id', $currentSession->id)
                ->where('bond', 'oui') // Frais obligatoires seulement
                ->get();

            $sessionTotal = $tuitions->sum('amount');

            return response()->json([
                'success' => true,
                'inscription' => $inscription,
                'current_session' => $currentSession,
                'tuitions' => $tuitions,
                'total_paid' => $totalPaid,
                'session_total' => $sessionTotal
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des détails : ' . $e->getMessage()
            ]);
        }
    }

    private function getCurrentPaymentSession($studyLevelId, $totalPaid, $allSessions)
    {
        $cumulativePaid = 0;

        foreach ($allSessions as $session) {
            $sessionTotal = Tuition::where('study_level_id', $studyLevelId)
                ->where('year_session_id', $session->id)
                ->where('bond', 'oui')
                ->sum('amount');

            if ($totalPaid < $cumulativePaid + $sessionTotal) {
                return $session;
            }

            $cumulativePaid += $sessionTotal;
        }

        return null; // Tous les frais ont été payés
    }

    public function history()
    {
        $parentId = Auth::id();

        $bills = Bill::with(['inscription.student', 'tuitions'])
            ->whereHas('inscription.student.supervisors', function($query) use ($parentId) {
                $query->where('supervisor_id', $parentId);
            })
            ->orderBy('paid_at', 'desc')
            ->paginate(20);

        return view('parent.payments.history', compact('bills'));
    }

    public function initiatePayment(Request $request)
    {
        try {
            $request->validate([
                'inscription_id' => 'required|exists:inscriptions,id',
                'session_id' => 'required|exists:year_sessions,id',
                'amount' => 'required|numeric|min:1'
            ]);

            $inscription = Inscription::with(['student', 'study_level'])->findOrFail($request->inscription_id);
            $session = YearSession::findOrFail($request->session_id);

            // Vérifier que cette inscription appartient au parent connecté
            $parentId = Auth::id();
            $isParentOfStudent = $inscription->student->supervisors()->where('supervisor_id', $parentId)->exists();
            
            if (!$isParentOfStudent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Accès non autorisé'
                ]);
            }

            // Utiliser le service KKiaPay
            $kkiaPayService = new \App\Services\KKiaPayService();
            
            $reason = "Frais scolaires - {$inscription->student->getFullName()} - {$inscription->study_level->specification} - {$session->name}";
            
            $webhookData = [
                'inscription_id' => $inscription->id,
                'session_id' => $session->id,
                'parent_id' => $parentId,
                'amount' => $request->amount
            ];

            // Générer l'URL de paiement
            $callbackUrl = route('parent.payments.callback');
            $paymentUrl = $kkiaPayService->generatePaymentUrl(
                $request->amount,
                $reason,
                $callbackUrl,
                $webhookData
            );

            return response()->json([
                'success' => true,
                'message' => 'Redirection vers KKiaPay...',
                'payment_url' => $paymentUrl
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'initiation du paiement : ' . $e->getMessage()
            ]);
        }
    }

    public function paymentCallback(Request $request)
    {
        try {
            $transactionId = $request->input('transaction_id');
            $status = $request->input('status');

            if (!$transactionId) {
                return redirect()->route('parent.payments.index')
                    ->with('error', 'Transaction non trouvée');
            }

            // Vérifier le paiement via l'API KKiaPay
            $kkiaPayService = new \App\Services\KKiaPayService();
            $verification = $kkiaPayService->verifyPayment($transactionId);

            if (!$verification['success']) {
                return redirect()->route('parent.payments.index')
                    ->with('error', 'Impossible de vérifier le paiement');
            }

            $transactionData = $verification['data'];

            if ($transactionData['status'] === 'SUCCESS') {
                // Vérifier si le paiement n'existe pas déjà
                $existingBill = Bill::where('transaction_id', $transactionId)->first();
                
                if (!$existingBill) {
                    $data = json_decode($transactionData['data'], true);

                    $user = User::find(Auth::user()->id);
                    
                    $bill = Bill::create([
                        'inscription_id' => $data['inscription_id'],
                        'amount_paid' => $transactionData['amount'],
                        'payment_method' => 'kkiapay',
                        'transaction_id' => $transactionId,
                        'paid_by' => $user->getFullName(),
                        'paid_with' => $transactionData['type'] ?? 'mobile_money',
                        'paid_at' => now()
                    ]);
                }

                return redirect()->route('parent.payments.index')
                    ->with('success', 'Paiement effectué avec succès !');
            } else {
                return redirect()->route('parent.payments.index')
                    ->with('error', 'Le paiement a échoué');
            }

        } catch (\Exception $e) {
            Log::error('Payment callback error: ' . $e->getMessage());
            return redirect()->route('parent.payments.index')
                ->with('error', 'Erreur lors du traitement du paiement');
        }
    }

    public function paymentWebhook(Request $request)
    {
        try {
            $signature = $request->header('X-KKiaPay-Signature');
            $payload = $request->getContent();

            $kkiaPayService = new \App\Services\KKiaPayService();
            
            if (!$kkiaPayService->validateWebhookSignature($payload, $signature)) {
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            $data = json_decode($payload, true);
            
            // Traiter la notification webhook
            if ($data['status'] === 'SUCCESS') {
                $webhookData = json_decode($data['data'], true);
                
                // Vérifier si le paiement n'a pas déjà été enregistré
                $existingBill = Bill::where('transaction_id', $data['transactionId'])->first();
                
                if (!$existingBill) {
                    Bill::create([
                        'inscription_id' => $webhookData['inscription_id'],
                        'amount_paid' => $data['amount'],
                        'payment_method' => 'kkiapay',
                        'transaction_id' => $data['transactionId'],
                        'paid_by' => 'Parent',
                        'paid_with' => 'mobile_money',
                        'paid_at' => now()
                    ]);
                }
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('KKiaPay webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal error'], 500);
        }
    }
}
