<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Inscription;
use App\Models\Tuition;
use App\Models\Student;
use App\Models\StudyLevel;
use App\Models\YearSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Afficher la liste des paiements pour les administrateurs
     */
    public function index(Request $request)
    {
        $query = Bill::with([
            'inscriptions.student',
            'inscriptions.study_level',
            'inscriptions.school_year',
            'tuitions.yearSession'
        ]);

        // Filtres
        if ($request->filled('school_year')) {
            $query->whereHas('inscriptions', function($q) use ($request) {
                $q->where('school_year_id', $request->school_year);
            });
        }

        if ($request->filled('study_level')) {
            $query->whereHas('inscriptions', function($q) use ($request) {
                $q->where('study_level_id', $request->study_level);
            });
        }

        if ($request->filled('fee_type')) {
            $query->whereHas('tuitions', function($q) use ($request) {
                $q->where('type', $request->fee_type);
            });
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(20);
        $studyLevels = StudyLevel::all();
        $schoolYears = DB::table('school_years')->pluck('id');
        $feeTypes = Tuition::distinct()->pluck('type');
        $yearSessions = YearSession::all();

        return view('admin.payments.index', compact('payments', 'studyLevels', 'schoolYears', 'feeTypes', 'yearSessions'));
    }

    /**
     * Afficher le formulaire de création de paiement
     */
    public function create()
    {
        return view('admin.payments.create');
    }

    /**
     * Rechercher un élève pour le paiement
     */
    public function searchStudent(Request $request)
    {
        $request->validate([
            'search' => 'required|string|min:2'
        ]);

        $currentYear = date("Y") . "-" . (date("Y") + 1);
        $search = $request->search;

        $inscriptions = Inscription::with(['student', 'study_level'])
            ->where('school_year_id', $currentYear)
            ->where('status', 'accepté')
            ->whereHas('student', function($query) use ($search) {
                $query->where('firstname', 'like', "%{$search}%")
                      ->orWhere('lastname', 'like', "%{$search}%")
                      ->orWhere(DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', "%{$search}%");
            })
            ->get();

        return response()->json([
            'success' => true,
            'inscriptions' => $inscriptions
        ]);
    }

    /**
     * Obtenir les frais disponibles pour une inscription
     */
    public function getAvailableFees($inscriptionId)
    {
        $inscription = Inscription::with(['study_level', 'student'])->findOrFail($inscriptionId);
        $availableFees = $this->calculateAvailableFees($inscription);

        return response()->json([
            'success' => true,
            'inscription' => $inscription,
            'fees' => $availableFees
        ]);
    }

    /**
     * Enregistrer un paiement
     */
    public function store(Request $request)
    {
        $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'tuition_id' => 'required|exists:tuitions,id',
            'amount_paid' => 'required|numeric|min:0',
            'paid_by' => 'required|string',
            'paid_with' => 'required|string|in:espèces,chèque,virement,carte'
        ]);

        try {
            DB::beginTransaction();

            $inscription = Inscription::findOrFail($request->inscription_id);
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

            // Créer le paiement
            Bill::create([
                'inscription_id' => $request->inscription_id,
                'tuition_id' => $request->tuition_id,
                'amount_paid' => $request->amount_paid,
                'payment_step' => $selectedFee['payment_step'],
                'paid_by' => $request->paid_by,
                'paid_with' => $request->paid_with,
                'paid_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paiement enregistré avec succès'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement du paiement'
            ], 500);
        }
    }

    /**
     * Calculer les frais disponibles pour une inscription
     */
    private function calculateAvailableFees($inscription)
    {
        $availableFees = [];
        $currentYear = date("Y") . "-" . (date("Y") + 1);

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
}