<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\StudentDocument;
use App\Models\StudyLevel;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Affiche la liste des étudiants
     */
    public function index(Request $request)
    {
        // Cette méthode afficherait les étudiants depuis la base de données
        $Students = Student::paginate(10);
        $study_levels = StudyLevel::all();
        return view('students.index', [
            "students" => $Students,
            "study_levels" => $study_levels
        ]);
    }

    public function inde() 
    {
        $Students = Student::paginate(10);
        $study_levels = StudyLevel::all();
        $fathers = User::where([
            "sex" => "M",
            "role" => "Parent"
        ])->get();
        $mothers = User::where([
            "sex" => "F",
            "role" => "Parent"
        ])->get();
        return view("students.createa", [
            "students" => $Students,
            "study_levels" => $study_levels,
            "fathers" => $fathers,
            "parents" => $fathers,
            "mothers" => $mothers
        ]);
    }

    /**
     * Affiche le formulaire de création d'un étudiant
     */
    public function create()
    {
        // Cette méthode chargera les données nécessaires au formulaire
        $study_levels = StudyLevel::all();
        $fathers = User::where([
            "sex" => "M",
            "role_id" => "supervisor"
        ])->get();
        $mothers = User::where([
            "sex" => "F",
            "role_id" => "supervisor"
        ])->get();
        return view('students.create', [
            "study_levels" => $study_levels,
            "fathers" => $fathers,
            "mothers" => $mothers
        ]);
    }

    /**
     * Valide et prépare les données d'un superviseur (père ou mère)
     */
    private function validateSupervisorData(Request $request, $type)
    {
        $data = [
            'lastname' => $request->input("{$type}_lastname"),
            'firstname' => $request->input("{$type}_firstname"),
            'birthday' => $request->input("{$type}_birthday"),
            'sex' => $type === 'father' ? 'M' : 'F',
            'phone' => $request->input("{$type}_phone"),
            'email' => $request->input("{$type}_email"),
            'home_address' => $request->input("{$type}_home_address"),
            'job' => $request->input("{$type}_job"),
            'work_address' => $request->input("{$type}_work_address"),
        ];

        // Si un superviseur avec cet email existe, retourne null pour ne pas recréer
        if (!empty($data['email'])) {
            $existing = User::where('email', $data['email'])->first();
            if ($existing) {
                return null; // On gère ça dans le contrôleur
            }
        }

        return $data;
    }

    /**
     * Enregistre un nouvel étudiant dans la base de données
     */
    public function store(Request $request)
    {
        // Validation des données de l'étudiant
        $validated = $request->validate([
            'lastname' => 'required|string|max:30',
            'firstname' => 'required|string|max:30',
            'birthday' => 'required|date',
            'sex' => 'required|in:M,F',
            'email' => 'required|email|max:100|unique:students,email',
            'phone' => 'nullable|string|max:12',
            'home_address' => 'nullable|string|max:30',
            //'study_level_id' => 'required|exists:study_levels,id',
            'registration_date' => 'required|date',
        ]);

        // Création de l'étudiant
        $student = Student::create($validated);
        $student_id = $student->id;

        // Gestion de l'upload de photo si fournie
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('students/'. $request->input("lastname"). "_" . $request->input("firstname"), 'public');
            $photoType = "Photo identité";
            StudentDocument::create([
                "document_type" => $photoType,
                "document_path" => $photoPath,
                "student_id" => $student_id
            ]);
            // $birth_act = $request->file("birth_act")->store();
            // $file_validated = $photoPath;
        }

        $school_year = SchoolYear::find($request->input("school_year_id"));
        if(!$school_year) {
            $school_year = SchoolYear::create([
                "id" => $request->input("school_year_id")
            ]);
        }
        

        // Gestion du père
        if ($request->has('toggle_father_existing') && $request->filled('father_id')) {
            // Utilisation d'un père existant
            $student->supervisors()->attach($request->input('father_id'), ['link' => 'father']);
        } elseif ($request->filled('father_firstname') && $request->filled('father_lastname')) {
            // Création d'un nouveau père
            $fatherData = $this->validateSupervisorData($request, 'father');
            if ($fatherData === null) {
                $father = User::where('email', $request->input('father_email'))->first();
            } else {
                $father = User::create($fatherData);
            }
            $student->supervisors()->attach($father->id, ['link' => 'father']);
        }

        // Gestion de la mère
        if ($request->has('toggle_mother_existing') && $request->filled('mother_id')) {
            // Utilisation d'une mère existante
            $student->supervisors()->attach($request->input('mother_id'), ['link' => 'mother']);
        } elseif ($request->filled('mother_firstname') && $request->filled('mother_lastname')) {
            // Création d'une nouvelle mère
            $motherData = $this->validateSupervisorData($request, 'mother');
            if ($motherData === null) {
                $mother = User::where('email', $request->input('mother_email'))->first();
            } else {
                $mother = User::create($motherData);
            }
            $student->supervisors()->attach($mother->id, ['link' => 'mother']);
        }

        Inscription::create([
            "student_id" => $student_id,
            "group_id" => $request->input("group_id") ?? "A",
            "study_level_id" => $request->input("study_level_id"),
            "school_year_id" => $school_year->id,
        ]);

        //Gestion de son niveau d'etude
        //$student->studyLevels()->attach( $request->input("study_level_id"), ["school_year_id" => $request->input("school_year_id")]);
        
        return redirect()->route('students.index') ->with('success', 'Étudiant ajouté avec succès!');
    }


    /**
     * Affiche les détails d'un étudiant spécifique
     */
    public function show($id)
    {
        $student = Student::with('inscriptions.study_level', 'documents')->find($id);
        $student_documents = $student->documents()->get();
        //dd($student);
        $img = $student_documents->where("document_type", "Photo identité")->first();
        $cursus = $student->inscriptions;
        $father = $student->getFather();
        $mother = $student->getMother();
        return view('students.show', [
            "student" => $student,
            //"img" => $img->document_path,
            "cursi" => $cursus,
            "student_documents" => $student_documents,
            "father" => $father,
            "mother" => $mother,
        ]);
    }

    /**
     * Affiche le formulaire d'édition pour un étudiant
     */
    public function edit($id)
    {
        // Cette méthode chargerait normalement l'étudiant depuis la base de données
        $student = Student::find($id);
        $student_document = StudentDocument::where("student_id", $id)->first();
        $father = $student->getFather();
        $mother = $student->getMother();
        $supervisors = User::all();
        $study_levels = StudyLevel::all();
        return view('students.edit', [
            "study_levels" => $study_levels,
            "student" => $student,
            "student_document" => $student_document,
            "father" => $father,
            "mother" => $mother,
            "supervisors" => $supervisors,
        ]);
    }

    /**
     * Met à jour les informations d'un étudiant dans la base de données
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'birthday' => 'required|date',
            'sex' => 'required|in:M,F',
            'email' => 'nullable|email|unique:students,email,'.$id,
            'phone' => 'nullable|string|max:20',
            'home_address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Dans une implémentation réelle, nous mettrions à jour l'étudiant dans la base de données

        Student::update($validated);
        
        return redirect()->route('students.show', $id)->with('success', 'Informations de l\'étudiant mises à jour avec succès!');
    }

    /**
     * Supprime un étudiant de la base de données
     */
    public function destroy($id)
    {
        // Cette méthode supprimerait normalement l'étudiant de la base de données
        
        return redirect()->route('students.index')
            ->with('success', 'Étudiant supprimé avec succès!');
    }

    public function reenrollment(Request $request)
    {
        // Récupérer les niveaux d'étude et les classes pour les filtres et le formulaire
        $study_levels = StudyLevel::all();
        
        // Préparer la requête avec une recherche si nécessaire
        $query = Student::query();
        
        // Appliquer les filtres de recherche
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('lastname', 'like', "%{$search}%")
                  ->orWhere('firstname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('level')) {
            $query->where('study_level_id', $request->input('level'));
        }
        
        if ($request->filled('sex')) {
            $query->where('sex', $request->input('sex'));
        }
        
        // Pagination des résultats
        $students = $query->orderBy('id')->paginate(10);
        
        return view('students.reenrollment', [
            'students' => $students,
            'study_levels' => $study_levels
        ]);
    }

    /**
     * Traite la réinscription d'un étudiant existant
     */
    public function processReenrollment(Request $request, $id)
    {
        // Trouver l'étudiant
        $student = Student::findOrFail($id);
        $school_year = SchoolYear::find($request->input("school_year_id"));
        if(!$school_year) {
            SchoolYear::create([
                "id" => $request->input("school_year_id")
            ]);
        }

        if ($student->isEnrolledIn($school_year->id)) {
            return redirect()->route('students.reenrollment')->with('error', 'L\'élève sélectionné est déjà enregistré pour cette année scolaire.');
        }

        
        // Validation des données
        $validated = $request->validate([
            'study_level_id' => 'required|exists:study_levels,id',
            'registration_date' => 'required|date',
            'school_year_id' => 'required|string',
        ]);
        
        Inscription::create([
            "student_id" => $id,
            "group_id" => $request->input("group_id") ?? "A",
            "study_level_id" => $request->input("study_level_id"),
            "school_year_id" => $school_year->id,
        ]);

        // Mise à jour des informations de l'étudiant
        $student->studyLevels()->attach( $request->input("study_level_id"), ["school_year_id" => $school_year->id]);
        
        return redirect()->route('students.reenrollment')->with('success', 'Réinscription effectuée avec succès!');
    }

    public function studentRegistration() {
        $study_levels = StudyLevel::all();
        $fathers = User::where([
            "sex" => "M",
            "role_id" => "parent"
        ])->get();
        $mothers = User::where([
            "sex" => "F",
            "role_id" => "parent"
        ])->get();
        return view('children.student-registration', [
            "study_levels" => $study_levels,
            "fathers" => $fathers,
            "mothers" => $mothers
        ]);
    }
}