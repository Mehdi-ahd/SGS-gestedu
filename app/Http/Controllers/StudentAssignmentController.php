<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\SchoolYear;
use App\Models\StudyLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentAssignmentController extends Controller
{
    /**
     * Afficher la page d'assignation des élèves aux groupes
     */
    public function index()
    {
        $study_levels = StudyLevel::all();
        $school_years = SchoolYear::all();
        return view('admin.student-group-assignment', [
            "study_levels" => $study_levels,
            "school_years" => $school_years
        ]);
    }

    /**
     * Obtenir les inscriptions acceptées pour un niveau d'étude
     */
    public function getInscriptions(Request $request)
    {
        try {
            $studyLevelId = $request->get('study_level_id');
            $schoolYear = $request->get('school_year', date('Y') . '-' . (date('Y') + 1));
            $status = $request->get('status', 'accepté');

            if (!$studyLevelId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Niveau d\'étude requis'
                ]);
            }

            $inscriptions = Inscription::with(['student', 'study_level', 'group'])
                ->where('study_level_id', $studyLevelId)
                ->where('school_year_id', $schoolYear)
                ->whereIn('status', ['accepté', 'en cours'])
                ->get();

            return response()->json([
                'success' => true,
                'inscriptions' => $inscriptions
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des inscriptions'
            ], 500);
        }
    }

    /**
     * Enregistrer les assignations d'élèves aux groupes
     */
    public function saveAssignments(Request $request)
    {
        try {
            $request->validate([
                'assignments' => 'required|array',
                'assignments.*.inscription_id' => 'required|exists:inscriptions,id',
                'assignments.*.group_id' => 'required|exists:groups,id',
                'study_level_id' => 'required|exists:study_levels,id'
            ]);

            DB::beginTransaction();

            $updatedCount = 0;
            foreach ($request->assignments as $assignment) {
                $inscription = Inscription::find($assignment['inscription_id']);
                
                // Vérifier que l'inscription appartient bien au niveau d'étude
                if ($inscription->study_level_id != $request->study_level_id) {
                    continue;
                }

                // Mettre à jour le group_id
                $inscription->update([
                    'group_id' => $assignment['group_id']
                ]);
                
                $updatedCount++;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "{$updatedCount} assignation(s) enregistrée(s) avec succès"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Réinitialiser les assignations pour un niveau d'étude
     */
    public function resetAssignments(Request $request)
    {
        try {
            $request->validate([
                'study_level_id' => 'required|exists:study_levels,id',
                'school_year' => 'required|string'
            ]);

            DB::beginTransaction();

            $updatedCount = Inscription::where('study_level_id', $request->study_level_id)
                ->where('school_year_id', $request->school_year)
                ->whereIn('status', ['accepté', 'en cours'])
                ->update(['group_id' => 'A']); // Groupe par défaut

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "{$updatedCount} assignation(s) réinitialisée(s)"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la réinitialisation'
            ], 500);
        }
    }
}
