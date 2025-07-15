<?php

namespace App\Http\Controllers;

use App\Models\StudyLevel;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        $studyLevels = StudyLevel::all();
        return view("school-structure.subjects", [
           "subjects" => $subjects,
           "studyLevels" => $studyLevels
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:subjects,name',
            'study_levels' => 'required|array|min:1',
            'study_levels.*' => 'exists:study_levels,id',
            'coefficients' => 'required|array|min:1',
            'coefficients.*' => 'integer|min:1|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        // Vérifier que les tableaux ont la même taille
        if (count($request->study_levels) !== count($request->coefficients)) {
            return response()->json([
                'success' => false,
                'message' => 'Le nombre de niveaux et de coefficients doit être identique'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Créer la matière
            $subject = Subject::create([
                'name' => $request->name,
                "code" => "A"
            ]);

            // Associer les niveaux d'études avec leurs coefficients
            $studyLevelData = [];
            for ($i = 0; $i < count($request->study_levels); $i++) {
                $studyLevelData[$request->study_levels[$i]] = [
                    'coefficient' => $request->coefficients[$i]
                ];
            }

            $subject->studyLevels()->attach($studyLevelData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Matière créée avec succès',
                'subject' => $subject->load('studyLevels')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la matière'
            ], 500);
        }
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
        $subject = Subject::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:subjects,name,' . $id,
            'study_levels' => 'sometimes|array',
            'study_levels.*' => 'exists:study_levels,id',
            'coefficients' => 'sometimes|array',
            'coefficients.*' => 'integer|min:1|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Mettre à jour les informations de base
            $subject->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            // Si de nouveaux niveaux sont fournis, les ajouter
            if ($request->has('study_levels') && $request->has('coefficients')) {
                if (count($request->study_levels) !== count($request->coefficients)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Le nombre de niveaux et de coefficients doit être identique'
                    ], 422);
                }

                // Préparer les nouvelles associations
                $newStudyLevelData = [];
                for ($i = 0; $i < count($request->study_levels); $i++) {
                    $newStudyLevelData[$request->study_levels[$i]] = [
                        'coefficient' => $request->coefficients[$i]
                    ];
                }

                // Ajouter les nouveaux niveaux (sans supprimer les existants)
                $subject->studyLevels()->syncWithoutDetaching($newStudyLevelData);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Matière mise à jour avec succès',
                'subject' => $subject->load('studyLevels')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la matière'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subject = Subject::findOrFail($id);
            
            DB::beginTransaction();

            // Supprimer les associations avec les niveaux d'études
            $subject->studyLevels()->detach();
            
            // Supprimer la matière
            $subject->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Matière supprimée avec succès'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la matière'
            ], 500);
        }
    }

    public function getSubjectLevels(string $id)
    {
        try {
            $subject = Subject::with('studyLevels')->findOrFail($id);
            
            $levels = $subject->studyLevels->map(function($level) {
                return [
                    'id' => $level->id,
                    'specification' => $level->specification,
                    'coefficient' => $level->pivot->coefficient
                ];
            });

            return response()->json([
                'success' => true,
                'levels' => $levels
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des niveaux'
            ], 500);
        }
    }

    /**
     * Remove a study level from a subject
     */
    public function removeSubjectLevel(string $subjectId, string $levelId)
    {
        try {
            $subject = Subject::findOrFail($subjectId);
            
            // Vérifier que le niveau est bien associé à cette matière
            if (!$subject->studyLevels()->where('study_level_id', $levelId)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce niveau n\'est pas associé à cette matière'
                ], 404);
            }

            // Supprimer l'association
            $subject->studyLevels()->detach($levelId);

            return response()->json([
                'success' => true,
                'message' => 'Niveau retiré de la matière avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du niveau'
            ], 500);
        }
    }

    /**
     * Update coefficient for a specific subject-level association
     */
    public function updateLevelCoefficient(Request $request, string $subjectId, string $levelId)
    {
        $validator = Validator::make($request->all(), [
            'coefficient' => 'required|integer|min:1|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Coefficient invalide (doit être entre 1 et 10)'
            ], 422);
        }

        try {
            $subject = Subject::findOrFail($subjectId);
            
            // Vérifier que le niveau est bien associé à cette matière
            if (!$subject->studyLevels()->where('study_level_id', $levelId)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce niveau n\'est pas associé à cette matière'
                ], 404);
            }

            // Mettre à jour le coefficient
            $subject->studyLevels()->updateExistingPivot($levelId, [
                'coefficient' => $request->coefficient
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Coefficient mis à jour avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du coefficient'
            ], 500);
        }
    }
}
