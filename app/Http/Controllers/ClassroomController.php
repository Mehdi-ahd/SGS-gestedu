<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\StudyLevel;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::with(['study_level.groups'])->orderBy('name', 'asc')->get();
        $studyLevels = StudyLevel::all();
        
        return view('school-structure.classrooms', [
            "classrooms" => $classrooms,
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
            'name' => 'required|string|max:255|unique:classrooms,name',
            'capacity' => 'nullable|integer|min:1|max:100',
            'group_id' => 'nullable|exists:groups,id'
        ], [
            'name.required' => 'Le nom de la salle est obligatoire',
            'name.unique' => 'Une salle avec ce nom existe déjà',
            'capacity.integer' => 'La capacité doit être un nombre entier',
            'capacity.min' => 'La capacité doit être au moins de 1',
            'capacity.max' => 'La capacité ne peut pas dépasser 100',
            'group_id.exists' => 'Le groupe sélectionné n\'existe pas'
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

            $classroom = Classroom::create([
                'name' => $request->name,
                'capacity' => $request->capacity
            ]);

            // Associer le groupe si fourni
            if ($request->group_id && $request->study_level) {
                $studyLevel = StudyLevel::findOrFail($request->study_level);
                if ($studyLevel->groups()->where('group_id', $request->group_id)->exists()) {
                    $studyLevel->groups()->syncWithoutDetaching([
                        $request->group_id => ["classroom_id" => $classroom->id,]
                    ]);
                };
            }

            DB::commit();

            // Recharger avec les relations
            $classroom = Classroom::with('study_level_group')->find($classroom->id);

            return response()->json([
                'success' => true,
                'message' => 'Salle de classe créée avec succès',
                'classroom' => [
                    'id' => $classroom->id,
                    'name' => $classroom->name,
                    'capacity' => $classroom->capacity,
                    'assigned_groups' => $classroom->study_level_group
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la salle de classe'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $classroom = Classroom::with('study_level_group')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'classroom' => [
                    'id' => $classroom->id,
                    'name' => $classroom->name,
                    'capacity' => $classroom->capacity,
                    'assigned_groups' => $classroom->study_level_group
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Salle de classe introuvable'
            ], 404);
        }
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
        $classroom = Classroom::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:classrooms,name,' . $id,
            'capacity' => 'nullable|integer|min:1|max:100',
            'group_id' => 'nullable|exists:groups,id'
        ], [
            'name.required' => 'Le nom de la salle est obligatoire',
            'name.unique' => 'Une salle avec ce nom existe déjà',
            'capacity.integer' => 'La capacité doit être un nombre entier',
            'capacity.min' => 'La capacité doit être au moins de 1',
            'capacity.max' => 'La capacité ne peut pas dépasser 100',
            'group_id.exists' => 'Le groupe sélectionné n\'existe pas'
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

            $classroom->update([
                'name' => $request->name,
                'capacity' => $request->capacity
            ]);

            // Gérer l'assignation du groupe
            if ($request->has('group_id')) {
                // Détacher tous les groupes existants
                $classroom->study_level_group()->detach();
                
                // Attacher le nouveau groupe si fourni
                if ($request->group_id && $request->study_level) {
                    // Vérifier que le groupe appartient bien au niveau d'étude sélectionné
                    $studyLevel = StudyLevel::findOrFail($request->study_level);
                    if ($studyLevel->groups()->where('group_id', $request->group_id)->exists()) {
                        $classroom->study_level_group()->attach($request->group_id, ['study_level_id' => $request->study_level]);
                    }
                }
            }

            DB::commit();

            // Recharger avec les relations
            $classroom = Classroom::with('study_level_group')->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Salle de classe modifiée avec succès',
                'classroom' => [
                    'id' => $classroom->id,
                    'name' => $classroom->name,
                    'capacity' => $classroom->capacity,
                    'assigned_groups' => $classroom->study_level_group
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification de la salle de classe'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $classroom = Classroom::findOrFail($id);
            
            DB::beginTransaction();

            // Détacher tous les groupes assignés
            $classroom->study_level_group()->detach();
            
            // Supprimer la salle de classe
            $classroom->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Salle de classe supprimée avec succès'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la salle de classe'
            ], 500);
        }
    }

    /**
     * Assigner un groupe à une salle de classe
     */
    public function assignGroup(Request $request, string $id)
    {
        $classroom = Classroom::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'group_id' => 'required|exists:groups,id',
            'study_level_id' => 'required|exists:study_levels,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides'
            ], 422);
        }

        try {
            // Vérifier que le groupe appartient bien au niveau d'étude
            //Non nécéssaire en fin de compte, mais on garde pour l'instant
            $studyLevel = StudyLevel::findOrFail($request->study_level_id);
            if (!$studyLevel->groups()->where('group_id', $request->group_id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce groupe n\'appartient pas au niveau d\'étude sélectionné'
                ], 422);
            }
            //

            // Vérifier si le groupe n'est pas déjà assigné
            if (!$classroom->study_level_group()->where('group_id', $request->group_id)->exists()) { //Verification non importante 
                //$classroom->study_level_group()->attach($request->group_id, ['study_level_id' => $request->study_level_id]);
                DB::table('group_study_level')
                    ->where('group_id', $request->group_id)
                    ->where('study_level_id', $request->study_level_id)
                    ->update(['classroom_id' => $classroom->id]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Groupe assigné avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'assignation'
            ], 500);
        }
    }

    /**
     * Désassigner un groupe d'une salle de classe
     */
    public function unassignGroup(Request $request, string $id)
    {
        $classroom = Classroom::findOrFail($id);
        $studyLevel = StudyLevel::findOrFail($request->input('study_level_id'));

        $validator = Validator::make($request->all(), [
            'group_id' => 'required|exists:groups,id',
            'study_level_id' => 'required|exists:study_levels,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Groupe invalide'
            ], 422);
        }

        try {
            DB::table('group_study_level')
                ->where('group_id', $request->group_id)
                ->where("study_level_id", $request->study_level_id)
                ->update(['classroom_id' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Groupe désassigné avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la désassignation'
            ], 500);
        }
    }

    /**
     * Obtenir les groupes d'un niveau d'étude
     */
    public function getGroups(Request $request)
    {
        $studyLevelId = $request->input('study_level_id');
        
        if (!$studyLevelId) {
            return response()->json([
                'success' => false,
                'message' => 'ID du niveau d\'étude requis'
            ], 400);
        }

        try {
            // Vérifier que le niveau d'étude existe
            $studyLevel = StudyLevel::findOrFail($studyLevelId);
            
            // Récupérer les groupes via la relation
            $allgroups = $studyLevel->groups()->get();

            $groupsWithClassroom = $studyLevel->groups() ->wherePivotNotNull('classroom_id') ->get();

            $groups = $allgroups->diff($groupsWithClassroom);
            
            // Formatter les données pour la réponse
            $groupsData = $groups->map(function($group) {
                return [
                    'id' => $group->id,
                    'name' => 'Groupe ' . $group->id
                ];
            });

            return response()->json([
                'success' => true,
                'groups' => $groupsData
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Niveau d\'étude introuvable'
            ], 404);
        } catch (\Exception $e) {
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des groupes'
            ], 500);
        }
    }
}
