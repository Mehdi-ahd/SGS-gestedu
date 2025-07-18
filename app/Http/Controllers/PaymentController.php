<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\StudyLevel;
use App\Models\Tuition;
use App\Models\User;
use App\Models\YearSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('payments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $study_levels = StudyLevel::all();
        $year_sessions = YearSession::all();
        return view('payments.create', [
            "study_levels" => $study_levels,
            "year_sessions" => $year_sessions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Tuition::create([
            "study_level_id" => $request->input("study_level_id"),
            "year_session_id" => $request->input("year_session_id"),
            "motif" => $request->input("fee_name"),
            "type" => $request->input("fee_type"),
            "amount" => $request->input("amount"),
            "bond" => $request->input("is_mandatory"),
            "due_date" => $request->input("due_date"),
        ]);

        return view("payments.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showPaymentForm()
    {
        $enrollments = User::with("students.inscriptions")->find(Auth::user()->id);
        //dd($enrollments->students->actualInscription());
        return view('children.payment');
    }
    /**
     * Récupère les élèves d'un parent pour le paiement (API)
     */
    public function getStudentsForPayment($parentId)
    {
        $enrollments = User::with("students.inscriptions")->find($parentId);
        return response()->json([
            'students' => $enrollments->students
        ]);
    }
    /**
     * Traite le paiement
     */
    public function storePayment(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'payment_type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $payment = Bill::create([
            'enrollment_id' => $validated['enrollment_id'],
            'payment_type' => $validated['payment_type'],
            'amount' => $validated['amount'],
            'paid_with' => $validated['payment_method'],
            'payment_date' => $validated['payment_date'],
            'reference' => $validated['reference'],
            'notes' => $validated['notes'],
            'status' => 'pending',
            'paid_by' => Auth::id()
        ]);
        return redirect()->route('parent.payment.form')->with('success', 'Paiement soumis avec succès. Il sera validé par l\'administration.');
    }
}
