<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Supervisor;
use App\Models\SupervisorDocument;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view("users.index", [
            "users" => $users,
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
        //
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        $user = User::find($id);
        return view("users.show", [
            "user" => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function editPermission(string $id)
    {
        $user = User::with(["role.permissions", "specificPermissions"])->find($id);
        $rolePermissions = $user->role->permissions;
        $specificPermissionGranted = $user->specificPermissions()->wherePivot("status", "granted")->get();
        $specificPermissiondenied = $user->specificPermissions()->wherePivot("status", "denied")->get();
        $userPermissions = $rolePermissions->diff($specificPermissiondenied)->merge($specificPermissionGranted);
        $permissions = Permission::all();
        $missingPermissions = $permissions->diff($userPermissions);
        return view("users.editPermission", [
            "user" => $user,
            "userPermissions" => $userPermissions,
            "missingPermissions" => $missingPermissions
        ]);
    }

    public function updatePermissions(Request $request)
    {
        $id = $request->input("user_id");
        $user = User::with("specificPermissions")->find($id);
        $granted = $request->input("granted", []);
        $denied = $request->input("denied", []);
        if($granted) {
            $grantedValues = [];
            foreach($granted as $permissionGranted) {
                $user->specificPermissions()->syncWithoutDetaching([
                    $permissionGranted => ["status" => "granted"]
                ]);
                $grantedValues[] = $permissionGranted;
            }
        }
        if($denied) {
            $deniedValues = [];
            foreach($denied as $permissionDenied) {
                if($user->specificPermissions()->where("permission_id", $permissionDenied)->wherePivot("status", "granted")->exists()) {
                    $user->specificPermissions()->updateExistingPivot($permissionDenied, [
                        "status" => "denied"
                    ]);
                } elseif($user->specificPermissions()->where("permission_id", $permissionDenied)->wherePivot("status", "denied")->exists()) {
                    continue;
                } else {
                    $user->specificPermissions()->attach([
                        $permissionDenied => ["status" => "denied"]
                    ]);
                }
                $deniedValues[] = $permissionDenied;
            }
        }

        return redirect()->route("users.editPermission", $id)->with("success", "Modifications éffectuées avec succès");
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


    public function showVerificationForm($id) 
    {
        $user = User::find($id);
        if($user->status != "en attente de soumission") {
            return redirect()->route("dashboard");
        }
        return view("dashboard.verification", [
            "user" => $user
        ]);
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
            'email' => 'required|email|max:100',
            'home_address' => 'required|string|max:100',
            'job' => 'nullable|string|max:30',
            'work_address' => 'nullable|string|max:30',
            'documentFile' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120' // 5MB
        ]);

        $user = User::find(Auth::user()->id);

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
                $documentPath = $request->file('documentFile')->store('supervisor_documents/'. $user->id, 'public');
            }

            // Créer le superviseur
            $supervisor = $user->update([
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'birthday' => $request->birthday,
                'sex' => $request->sex,
                'phone' => $request->phone,
                'second_phone' => $request->second_phone ?? null,
                'email' => $request->email,
                'home_address' => $request->home_address,
                'job' => $request->job,
                'work_address' => $request->work_address,
                "status" => "en attente de vérification",
            ]);
            

            //$user = User::find($request->user_id);
            // $user->update([
            //     "status" => "en attente de vérification",
            // ]);

            // Créer le document si un fichier est fourni
            $documentType = $request->documentType;
            if($documentType === "passport") {
                $documentType = "Passeport";
            }
            if ($documentPath) {
                UserDocument::create([
                    'user_id' => $user->id,
                    "document_number" => $request->documentNumber ?? $request->passportNumber,
                    'document_type' =>  $documentType,
                    'document_path' => $documentPath,
                ]);
            }

            // Mettre à jour le statut de l'utilisateur
            $user->status = 'en attente de vérification';
            $user->save();

            // Envoyer un email aux administrateurs
            $admins = User::where('role_id', 'admin')->get();
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new \App\Mail\IdentityVerificationCompleted($user));
            }

            return response()->json([
                'success' => true,
                'message' => 'Demande de vérification soumise avec succès',
                'supervisor_id' => $user->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la soumission: ' . $e->getMessage()
            ], 500);
        }
    }

    public function accountConfirmationIndex() 
    {
        $users = User::paginate(10);
        $usersInawait = $users->where("status", "en attente de soumission")->count();
        $usersInawaitConfirm = $users->where("status", "en attente de vérification")->count();
        $usersConfirm = $users->where("status", "verifié")->count();
        return view("users.accountIndex",[
            "users" => $users,
            "usersInawait" => $usersInawait,
            "usersInawaitConfirm" => $usersInawaitConfirm,
            "usersConfirm" => $usersConfirm,
        ]);
    }

    public function accountConfirmationShow($id)
    {
        $user = User::find($id);
        return view("users.accountShow", [
            "user" => $user,
        ]);
    }

    /**
     * Valider un compte utilisateur
     */
    public function validateAccount($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->status = 'actif';
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Compte validé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la validation : ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Rejeter un compte utilisateur
     */
    public function rejectAccount(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->status = 'rejeté';
            $user->rejection_reason = $request->input('reason', 'Documents non conformes');
            $user->save();

            // Supprimer les documents associés
            $user->documents()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Compte rejeté avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du rejet : ' . $e->getMessage()
            ]);
        }
    }
}
