<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Document;
use App\Models\StudyLevel;
use App\Models\Teaching;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Affiche la liste des enseignants
     */
    public function index(Request $request)
    {
        $teachers = User::where([
            "role_id" => "teacher"
        ])->get();
        return view('teachers.index', [
            "teachers" => $teachers
        ]);
    }

    /**
     * Affiche le formulaire de création d'un enseignant
     */
    public function create()
    {
        // Cette méthode chargera les données nécessaires au formulaire (matières, etc.)
        $subjects = Subject::all();
        if($subjects->count() > 10) {
            $number = $subjects->count() -5;
        } else {
            $number = $subjects->count();
        }
        return view('teachers.create', [
            "number" => $number,
            "subjects" => $subjects
        ]);
    }

    /**
     * Enregistre un nouvel enseignant dans la base de données
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'birthday' => 'required|date',
            'sex' => 'required|in:M,F',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'home_address' => 'required|string',
            'role_id' => 'required|string'
            // 'identity_document' => "nullable|file|mimes:pdf,jpg,png|max:5120",
            // 'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            // 'diploma.*' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $teacher = User::create($validated);

        $subjects = $request->input("subjects", []);
        foreach($subjects as $subject) {
            Teaching::create([
                "teacher_id" => $teacher->id,
                "subject_id" => $subject,
                "school_year_id" => date("Y") . "-" . date("Y")+1,
                "study_level_id" => 16
            ]);
        }
        
        return redirect()->route('teachers.index')->with('success', 'Enseignant ajouté avec succès!');
    }

    /**
     * Affiche les détails d'un enseignant spécifique
     */
    public function show($id)
    {
        $teacher = User::with(["teachings.studyLevel", "teachings.subject"])->find($id);
        return view('teachers.show', [
            "teacher" => $teacher,
        ]);
    }

    /**
     * Affiche le formulaire d'édition pour un enseignant
     */
    public function edit($id)
    {
        // Cette méthode chargerait normalement l'enseignant depuis la base de données
        // Pour l'instant, nous retournons simplement la vue
        return view('teachers.edit');
    }

    /**
     * Met à jour les informations d'un enseignant dans la base de données
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'birthday' => 'required|date',
            'sex' => 'required|in:M,F',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required|string|max:20',
            'home_address' => 'required|string',
            'qualifications' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'subjects' => 'nullable|array',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive,on_leave',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'new_document' => 'nullable|file|max:5120',
        ]);

        // Dans une implémentation réelle, nous mettrions à jour l'enseignant dans la base de données
        // et gérerions l'upload des fichiers
        
        return redirect()->route('teachers.show', $id)
            ->with('success', 'Informations de l\'enseignant mises à jour avec succès!');
    }

    /**
     * Supprime un enseignant de la base de données
     */
    public function destroy($id)
    {
        // Cette méthode supprimerait normalement l'enseignant de la base de données
        
        return redirect()->route('teachers.index')
            ->with('success', 'Enseignant supprimé avec succès!');
    }

    public function attendanceList()
    {
        $teacher = User::find(Auth::user()->id) ;
        
        $studyLevels = StudyLevel::with("subjects")->get();
        return view('attendance.create', [
            "studyLevels" => $studyLevels
        ]);
    }

    public function profile() {
        return view("teacher.profile");
    }
}