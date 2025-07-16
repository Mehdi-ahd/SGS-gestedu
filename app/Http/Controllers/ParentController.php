<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudyLevel;
use App\Models\Supervisor;
use App\Models\SupervisorDocument;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{
    public function index() 
    {
        $parents = User::where([
            "role_id" => "supervisor"
        ])->get();
        $study_levels = StudyLevel::all();
        $students = Student::all();
        return view("parents.index", [
            "parents" => $parents,
            "students" => $students,
            "study_levels" => $study_levels,
        ]);
    }

    public function create()
    {
        // Cette méthode chargera les données nécessaires au formulaire
        $children = Student::all();
        return view("parents.create", [
            "children" => $children,
        ]);
    }

    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'birthday' => 'required|date',
            'sex' => 'required|in:M,F',
            'email' => 'required|email|unique:supervisors,email',
            'phone' => 'string|max:20',
            'second_phone' => 'nullable|string|max:20',
            'home_address' => 'required|string',
            'job' => 'required|string',
            'role_id' => 'required|string'
        ]);

        $supervisor = User::create($validated);

        if($request->hasFile('identity_photo')) {
            //Implementer la validation pour plus de controle
            //'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            $photoPath = $request->file('identity_photo')->store('supervisors/'. $supervisor->id, 'public');
            $document_type = "Photo d'identité";
            UserDocument::create([
                "document_type" => $document_type,
                "document_path" => $photoPath,
                "user_id" => $supervisor->id,
            ]);
        }

        
        if($supervisor) {
            return redirect()->route("parents.index")->with('success', 'parent ajouté avec succès!');
        } 
        
    }

    public function show($id) {
        $supervisor = User::find($id);
        $children = $supervisor->students;
        $documents = $supervisor->documents()->get();
        if( $documents->where("document_type", "Photo d'identité")->first()) {
            $img = $documents->where("document_type", "Photo d'identité")->first();
        } else {
            $img = "";
        }
        return view("parents.show", [
            
            "supervisor" => $supervisor,
            "children" => $children,
            "documents" => $documents,
        ]);
    }

    public function edit($id) {
        $supervisor = User::find($id);
        $documents = $supervisor->documents()->get();
        $img = $documents->where("document_type", "Photo d'identité")->first();
        return view("parents.edit", [
            "parent" => $supervisor,
            "documents" => $documents,
        ]);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'birthday' => 'required|date',
            'sex' => 'required|in:M,F',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'nullable|string|max:20',
            'second_phone' => 'nullable|string|max:20',
            'home_address' => 'nullable|string',
            'job' => 'nullable|string'
        ]);

        $user = User::find($id);
        if (!$user) {
            return redirect()->route("parents.index")->with("error", "Parent non trouvé");
        }

        if($request->hasFile("identity_photo")) {
            $photoPath = $request->file("identity_photo")->store("users/".$id, "public");
            $document_type = "Photo d'identité";
            
            // Mettre à jour ou créer le document
            UserDocument::updateOrCreate(
                ['user_id' => $id, 'document_type' => $document_type],
                ['document_path' => $photoPath]
            );
        }

        $user->update($validated);
        return redirect()->route("parents.show", $id)->with("success", "Informations mises à jour avec succès");
    }

    // Nouvelle méthode pour la mise à jour du profil depuis le dashboard parent
    public function updateProfile(Request $request) {
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'birthday' => 'nullable|date',
            'sex' => 'nullable|in:M,F',
            'email' => 'required|email|unique:users,email,'.Auth::id(),
            'phone' => 'nullable|string|max:20',
            'second_phone' => 'nullable|string|max:20',
            'home_address' => 'nullable|string',
            'job' => 'nullable|string'
        ]);

        $user = User::find(Auth::user()->id);
        $user->update($validated);

        if($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('profiles/'.$user->id, 'public');
            
            // Mettre à jour ou créer le document photo de profil
            $user->update([
                "profile_picture" => $photoPath,
            ]);
        }

        return redirect()->route('parent.profile')->with('success', 'Profil mis à jour avec succès');
    }

    /**
     * Affiche le profil du parent
     */
    public function parentProfile() {
        $user = User::find(Auth::user()->id);

        $children = $user->students()->get();
        return view("parent.profile", [
            "user" => Auth::user(),
            "children" => $children
        ]);
    }

    /**
     * Affiche la page de vérification du parent
     */
    public function parentVerification() {
        return view("parent.verification", [
            "user" => Auth::user()
        ]);
    }

    public function destroy($id) {
        $supervisor = User::find($id);
        if($supervisor) {
            $supervisor->delete();
            return redirect()->route("parents.index")->with("success", "Parent supprimé avec succès");
        }
        return redirect()->route("parents.index")->with("error", "Parent non enregistré");
    }

    public function showiden() 
    {
        return view("parents.parent");
    }

    public function storeVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lastname' => 'required|string|max:30',
            'firstname' => 'required|string|max:30',
            'birthday' => 'required|date',
            'sex' => 'nullable|in:M,F',
            'phone' => 'required|string|max:12',
            'second_phone' => 'nullable|string|max:12',
            'email' => 'required|email|max:100|unique:supervisors,email',
            'home_address' => 'required|string|max:100',
            'job' => 'nullable|string|max:30',
            'work_address' => 'nullable|string|max:30',
            'documentFile' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120' // 5MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Gérer l'upload du fichier
            $documentPath = null;
            if ($request->hasFile('documentFile')) {
                $documentPath = $request->file('documentFile')->store('supervisor_documents', 'public');
            }

            $user = User::find(Auth::user()->id) ;
            // Créer le superviseur
            $supervisor = $user::update([
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'birthday' => $request->birthday,
                'sex' => $request->sex,
                'phone' => $request->phone,
                'second_phone' => $request->second_phone,
                'email' => $request->email,
                'home_address' => $request->home_address,
                'job' => $request->job,
                'work_address' => $request->work_address,
                // 'role' => $request->role
                
            ]);

            // Créer le document si un fichier est fourni
            if ($documentPath) {
                UserDocument::create([
                    'user_id' => $user->id,
                    'document_type' =>  'Pièce d\'identité',
                    'document_path' => $documentPath,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Demande de vérification soumise avec succès',
                'user_id' => $supervisor->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la soumission: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showChildren($id) {
        $children = User::find($id)->students()->get();
        return view("children.children", [
            "children" => $children,
        ]);
    }

    public function showStudentProfile($id) {
        $child = Student::find($id);
        return view('children.child-details', [
            "child" => $child,
        ]);
    }
}
