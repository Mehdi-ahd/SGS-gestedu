<?php

namespace App\Http\Controllers;

use App\Models\Tuition;
use App\Models\StudyLevel;
use App\Models\YearSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TuitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tuitions = Tuition::with(['studyLevel', 'yearSession'])
            ->orderBy('created_at', 'desc')
            ->get();

        $studyLevels = StudyLevel::orderBy('specification')->get();
        $yearSessions = YearSession::orderBy('id')->get();

        return view('school-structure.tuitions', [
            'tuitions' => $tuitions,
            'studyLevels' => $studyLevels,
            'yearSessions' => $yearSessions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $studyLevels = StudyLevel::orderBy('specification')->get();
        $yearSessions = YearSession::orderBy('id')->get();

        return response()->json([
            'study_levels' => $studyLevels,
            'year_sessions' => $yearSessions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'study_level_id' => 'required|exists:study_levels,id',
            'year_session_id' => 'required|exists:year_sessions,id',
            'motif' => 'required|string|max:191',
            'type' => 'required|string|max:191',
            'amount' => 'required|integer|min:0',
            'bond' => 'required|in:oui,non',
            'due_date' => 'required|date|after_or_equal:today'
        ]);

        try {
            DB::beginTransaction();

            $tuition = Tuition::create($validated);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Frais créé avec succès',
                    'tuition' => $tuition->load(['studyLevel', 'yearSession'])
                ], 201);
            }

            return redirect()->route('school-structure.tuitions.index')
                ->with('success', 'Frais créé avec succès');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur lors de la création du frais',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Erreur lors de la création du frais');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tuition = Tuition::with(['studyLevel', 'yearSession'])->findOrFail($id);

        return response()->json($tuition);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tuition $tuition)
    {
        $tuition->load('studyLevel');
        $studyLevels = StudyLevel::orderBy('specification')->get();

        return response()->json([
            'success' => true,
            'tuition' => $tuition,
            'study_levels' => $studyLevels
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tuition = Tuition::findOrFail($id);

        $validated = $request->validate([
            'study_level_id' => 'required|exists:study_levels,id',
            'year_session_id' => 'required|exists:year_sessions,id',
            'motif' => 'required|string|max:191',
            'type' => 'required|string|max:191',
            'amount' => 'required|integer|min:0',
            'bond' => 'required|in:oui,non',
            'due_date' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            $tuition->update($validated);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Frais mis à jour avec succès',
                    'tuition' => $tuition->load(['studyLevel', 'yearSession'])
                ]);
            }

            return redirect()->route('school-structure.tuitions.index')
                ->with('success', 'Frais mis à jour avec succès');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur lors de la mise à jour du frais',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Erreur lors de la mise à jour du frais');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tuition = Tuition::findOrFail($id);

        try {
            DB::beginTransaction();

            $tuition->delete();

            DB::commit();

            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Frais supprimé avec succès'
                ]);
            }

            return redirect()->route('school-structure.tuitions.index')
                ->with('success', 'Frais supprimé avec succès');

        } catch (\Exception $e) {
            DB::rollBack();

            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur lors de la suppression du frais',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Erreur lors de la suppression du frais');
        }
    }
}