<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Inscription;
use App\Models\StudyCategory;
use App\Models\StudyLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudyLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studyCategories = StudyCategory::all();
        $studyLevels = StudyLevel::all();
        $groups = Group::all();
        $inscriptions = Inscription::all();
        return view("school-structure.studyLevels",[
            "studyCategories" => $studyCategories,
            "studyLevels" => $studyLevels,
            "groups" => $groups,
            "inscriptions" =>$inscriptions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $studyCategories = StudyCategory::all();
        return view("school-structure.studyLevels-create", compact('studyCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'study_category_id' => 'required|exists:study_categories,id',
            'specification' => 'required|string|max:100|unique:study_levels,specification',
            'groups' => 'required|array|min:1',
            'groups.*' => 'required|string|max:5'
        ], [
            'specification.unique' => 'Un niveau d\'étude avec cette spécification existe déjà',
            'study_category_id.required' => 'La catégorie d\'étude est obligatoire',
            'study_category_id.exists' => 'La catégorie d\'étude sélectionnée n\'existe pas',
            'groups.required' => 'Au moins un groupe est requis',
            'groups.min' => 'Au moins un groupe est requis'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            // Créer le niveau d'étude
            $studyLevel = StudyLevel::create([
                'study_category_id' => $request->study_category_id,
                'specification' => $request->specification
            ]);

            // Créer les groupes et les associer au niveau d'étude
            $groups = [];
            foreach ($request->groups as $groupName) {
                // Créer le groupe s'il n'existe pas
                $group = Group::firstOrCreate(['id' => $groupName]);
                
                // Associer le groupe au niveau d'étude via la table pivot
                $studyLevel->groups()->attach($group->id);
                
                $groups[] = [
                    'id' => $group->id,
                    'name' => $group->id,
                    'students_count' => 0
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Niveau d\'étude créé avec succès',
                'level' => [
                    'id' => $studyLevel->id,
                    'specification' => $studyLevel->specification,
                    'study_category_id' => $studyLevel->study_category_id,
                    'groups' => $groups
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du niveau d\'étude'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $studyLevel = StudyLevel::with(['studyCategory', 'groups.inscriptions'])->findOrFail($id);
            
            $groups = $studyLevel->groups->map(function($group) {
                return [
                    'id' => $group->id,
                    'name' => $group->id,
                    'students_count' => $group->inscriptions->count()
                ];
            });

            return response()->json([
                'success' => true,
                'level' => [
                    'id' => $studyLevel->id,
                    'specification' => $studyLevel->specification,
                    'study_category_id' => $studyLevel->study_category_id,
                    'groups' => $groups
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Niveau d\'étude introuvable'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $studyLevel = StudyLevel::with(['studyCategory', 'groups'])->findOrFail($id);
        // $studyCategories = StudyCategory::all();
        // return view("school-structure.studyLevels-edit", compact('studyLevel', 'studyCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $studyLevel = StudyLevel::findOrFail($id);

        // Pour les requêtes PUT avec FormData, récupérer les données depuis le contenu brut
        $inputData = $request->all();
        if (empty($inputData) && $request->getContent()) {
            parse_str($request->getContent(), $inputData);
        }

        $validator = Validator::make($inputData, [
            'study_category_id' => 'required|exists:study_categories,id',
            'specification' => 'required|string|max:100|unique:study_levels,specification,' . $id,
            'new_groups' => 'sometimes|array',
            'new_groups.*' => 'string|max:5',
            'groups_to_remove' => 'sometimes|array',
            'groups_to_remove.*' => 'exists:groups,id'
        ], [
            'specification.unique' => 'Un niveau d\'étude avec cette spécification existe déjà',
            'study_category_id.required' => 'La catégorie d\'étude est obligatoire',
            'study_category_id.exists' => 'La catégorie d\'étude sélectionnée n\'existe pas'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
           
            // Mettre à jour les informations de base
            $studyLevel->update([
                'study_category_id' => $inputData['study_category_id'],
                'specification' => $inputData['specification']
            ]);

            // Supprimer les groupes marqués pour suppression
            if (isset($inputData['groups_to_remove'])) {
                foreach ($inputData['groups_to_remove'] as $groupId) {
                    $group = Group::find($groupId);
                    if ($group) {
                        // Vérifier qu'il n'y a pas d'inscriptions
                        if ($group->inscriptions()->count() == 0) {
                            // Détacher de ce niveau d'étude
                            $studyLevel->groups()->detach($groupId);
                            
                            // Si le groupe n'est associé à aucun autre niveau, le supprimer
                            if ($group->studyLevels()->count() == 0) {
                                $group->delete();
                            }
                        }
                    }
                }
            }

            // Ajouter les nouveaux groupes
            if (isset($inputData['new_groups'])) {
                foreach ($inputData['new_groups'] as $groupName) {
                    if (!empty($groupName)) {
                        // Créer le groupe s'il n'existe pas
                        $group = Group::firstOrCreate(['id' => $groupName]);
                        
                        // Vérifier que le groupe n'est pas déjà associé à ce niveau
                        if (!$studyLevel->groups()->where('group_id', $groupName)->exists()) {
                            $studyLevel->groups()->attach($groupName);
                        }
                    }
                }
            }

            // Recharger le niveau avec ses groupes
            $studyLevel = StudyLevel::with(['groups.inscriptions'])->find($id);
            
            $groups = $studyLevel->groups->map(function($group) {
                return [
                    'id' => $group->id,
                    'name' => $group->id,
                    'students_count' => $group->inscriptions->count()
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Niveau d\'étude modifié avec succès',
                'level' => [
                    'id' => $studyLevel->id,
                    'specification' => $studyLevel->specification,
                    'study_category_id' => $studyLevel->study_category_id,
                    'groups' => $groups
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification du niveau d\'étude'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $studyLevel = StudyLevel::findOrFail($id);

            // Vérifier s'il y a des inscriptions dans les groupes de ce niveau
            $totalInscriptions = 0;
            foreach ($studyLevel->groups as $group) {
                $totalInscriptions += $group->inscriptions()->count();
            }

            if ($totalInscriptions > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer ce niveau car il contient des étudiants inscrits'
                ], 422);
            }

            // Détacher les groupes du niveau d'étude
            foreach ($studyLevel->groups as $group) {
                $studyLevel->groups()->detach($group->id);
                
                // Si le groupe n'est associé à aucun autre niveau, le supprimer
                if ($group->studyLevels()->count() == 0) {
                    $group->delete();
                }
            }
            
            // Supprimer le niveau d'étude
            $studyLevel->delete();

            return response()->json([
                'success' => true,
                'message' => 'Niveau d\'étude supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du niveau d\'étude'
            ], 500);
        }
    }
}
