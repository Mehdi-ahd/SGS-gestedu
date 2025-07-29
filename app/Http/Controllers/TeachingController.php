<?php

namespace App\Http\Controllers;

use App\Mail\TeacherAssigned;
use App\Models\Teaching;
use App\Models\StudyLevel;
use App\Models\Group;
use App\Models\Subject;
use App\Models\User;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TeachingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachings = Teaching::with(['studyLevel', 'group', 'subject', 'teacher', 'schoolYear'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $studyLevels = StudyLevel::orderBy('specification')->get();
        $teachers = User::where('role_id', 'teacher')->orderBy('lastname')->get();
        $subjects = Subject::orderBy('name')->get();
        $schoolYears = SchoolYear::orderBy('id')->get();
        
        return view('school-structure.teachings', compact('teachings', 'studyLevels', 'teachers', 'subjects', 'schoolYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $studyLevels = StudyLevel::orderBy('specification')->get();
        $teachers = User::where('role_id', 'teacher')->orderBy('lastname')->get();
        $subjects = Subject::orderBy('name')->get();
        $schoolYears = SchoolYear::orderBy('id')->get();
        
        return response()->json([
            'study_levels' => $studyLevels,
            'teachers' => $teachers,
            'subjects' => $subjects,
            'school_years' => $schoolYears
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'study_level_id' => 'required|exists:study_levels,id',
            'group_id' => 'required|exists:groups,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'school_year_id' => 'required|exists:school_years,id'
        ]);

        // Vérifier qu'il n'y a pas déjà un enseignement pour ce groupe/matière/année
        $existingTeaching = Teaching::where([
            'study_level_id' => $validated['study_level_id'],
            'group_id' => $validated['group_id'],
            'subject_id' => $validated['subject_id'],
            'school_year_id' => $validated['school_year_id']
        ])->first();

        if ($existingTeaching) {
            return response()->json([
                'success' => false,
                'message' => 'Un enseignement existe déjà pour ce groupe et cette matière dans cette année scolaire.'
            ], 422);
        }

        $teaching = Teaching::create($validated);
        
        $teaching->load(['studyLevel', 'group', 'subject', 'teacher', 'schoolYear']);

        // Envoyer un email au professeur assigné
        $teacher = User::find($validated['teacher_id']);
        if ($teacher) {
            Mail::to($teacher->email)->send(
                new TeacherAssigned($teaching, $teacher)
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Enseignement créé avec succès',
            'teaching' => $teaching
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Teaching $teaching)
    {
        $teaching->load(['studyLevel', 'group', 'subject', 'teacher', 'schoolYear']);
        
        return response()->json([
            'success' => true,
            'teaching' => $teaching
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teaching $teaching)
    {
        $teaching->load(['studyLevel', 'group', 'subject', 'teacher', 'schoolYear']);
        
        $studyLevels = StudyLevel::orderBy('specification')->get();
        $teachers = User::where('role_id', 'teacher')->orderBy('lastname')->get();
        $subjects = Subject::orderBy('name')->get();
        $schoolYears = SchoolYear::orderBy('id')->get();
        
        return response()->json([
            'success' => true,
            'teaching' => $teaching,
            'study_levels' => $studyLevels,
            'teachers' => $teachers,
            'subjects' => $subjects,
            'school_years' => $schoolYears
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teaching $teaching)
    {
        $validated = $request->validate([
            'study_level_id' => 'required|exists:study_levels,id',
            'group_id' => 'required|exists:groups,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'school_year_id' => 'required|exists:school_years,id'
        ]);

        // Vérifier qu'il n'y a pas déjà un enseignement pour ce groupe/matière/année (sauf celui en cours de modification)
        $existingTeaching = Teaching::where([
            'study_level_id' => $validated['study_level_id'],
            'group_id' => $validated['group_id'],
            'subject_id' => $validated['subject_id'],
            'school_year_id' => $validated['school_year_id']
        ])->where('id', '!=', $teaching->id)->first();

        if ($existingTeaching) {
            return response()->json([
                'success' => false,
                'message' => 'Un enseignement existe déjà pour ce groupe et cette matière dans cette année scolaire.'
            ], 422);
        }

        $teaching->update($validated);
        
        $teaching->load(['studyLevel', 'group', 'subject', 'teacher', 'schoolYear']);

        return response()->json([
            'success' => true,
            'message' => 'Enseignement mis à jour avec succès',
            'teaching' => $teaching
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teaching $teaching)
    {
        $teaching->delete();

        return response()->json([
            'success' => true,
            'message' => 'Enseignement supprimé avec succès'
        ]);
    }

    /**
     * Get groups for a specific study level
     */
    public function getGroups(Request $request)
    {
        $studyLevelId = $request->get('study_level_id');
        
        if (!$studyLevelId) {
            return response()->json([
                'success' => false,
                'message' => 'ID du niveau d\'étude requis'
            ], 400);
        }

        // Récupérer le niveau d'étude avec ses groupes
        $studyLevel = StudyLevel::with('groups')->find($studyLevelId);
        
        if (!$studyLevel) {
            return response()->json([
                'success' => false,
                'message' => 'Niveau d\'étude introuvable'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'groups' => $studyLevel->groups
        ]);
    }
}
