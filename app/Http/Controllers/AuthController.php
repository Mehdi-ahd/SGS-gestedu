<?php

namespace App\Http\Controllers;

use App\Models\InvitationToken;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }
    
    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegisterForm($token = null)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        // Si un token est fourni, vérifier sa validité
        if ($token) {
            $invitationToken = InvitationToken::where('token', $token)->first();
            
            if (!$invitationToken || !$invitationToken->isValid()) {
                return redirect()->route('register')->with('error', 'Token d\'invitation invalide ou expiré.');
            }
        }
        
        return view('auth.register', [
            "token" => $token
        ]);
    }

    /**
     * Gère l'inscription d'un nouvel utilisateur
     */
    public function register(Request $request, $token = null)
    {
        $validator = Validator::make($request->all(), [
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $token = $request->input("token");
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except('password', 'password_confirmation'));
        }
        
        // Déterminer le rôle en fonction du token
        $roleId = "supervisor"; // Par défaut, rôle parent
        
        if ($token) {
            $invitationToken = InvitationToken::where('token', $token)->first();
            
            if ($invitationToken && $invitationToken->isValid()) {
                $roleId = $invitationToken->role_id;
                
                // Supprimer le token après utilisation
                $invitationToken->delete();
            } else {
                return back()->with('error', 'Token d\'invitation invalide ou expiré.');
            }
        }
        
        $role = Role::find($roleId);
        
        $user = User::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        // Envoyer un email aux administrateurs
        $admins = User::where('role_id', 'admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new \App\Mail\NewUserRegistered($user));
        }

        return redirect()->route("login")->with('success', 'Compte créé avec succès! Bienvenue dans GestEdu.');
    }

    /**
     * Afficher la page de gestion des tokens d'invitation
     */
    public function showInvitationTokens()
    {
        $tokens = InvitationToken::with('role')->orderBy('created_at', 'desc')->get();
        $roles = Role::whereIn('id', ['admin', 'teacher'])->get();
        
        return view('admin.invitation-tokens', compact('tokens', 'roles'));
    }

    /**
     * Générer un token d'invitation
     */
    public function generateInvitationToken(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'email' => 'required|email'
        ]);

        try {
            // Générer un token unique
            $token = Str::random(64);
            
            // Créer le token d'invitation
            $invitationToken = InvitationToken::create([
                'token' => $token,
                'role_id' => $request->role_id,
                'validity_period' => now()->addDays(7), // Valide 7 jours
            ]);

            // Générer le lien d'inscription
            $invitationLink = route('register.with.token', ['token' => $token]);

            // Envoyer l'email avec le lien d'invitation
            $role = Role::find($request->role_id);
            
            Mail::to($request->email)->send(new \App\Mail\InvitationEmail($invitationLink, $role->name));

            return response()->json([
                'success' => true,
                'message' => 'Token d\'invitation généré avec succès',
                'invitation_link' => $invitationLink,
                'expires_at' => $invitationToken->validity_period->format('d/m/Y à H:i')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération du token : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Redirige l'utilisateur en fonction de son rôle
     */
    private function redirectBasedOnRole($user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('dashboard.admin');
        } elseif ($user->isTeacher()) {
            return redirect()->route('dashboard.teacher');
        } elseif ($user->isStudent()) {
            return redirect()->route('dashboard.student');
        } elseif ($user->isParent()) {
            return redirect()->route('dashboard.parent');
        } elseif ($user->isAccountant()) {
            return redirect()->route('dashboard.accountant');
        } else {
            return redirect()->route('dashboard');
        }
    }
    
    /**
     * Gère la tentative de connexion
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->withInput($request->except('password'));
    }
    
    /**
     * Déconnecte l'utilisateur
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
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
