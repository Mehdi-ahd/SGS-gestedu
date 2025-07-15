<?php

namespace App\Http\Controllers;

use App\Models\InvitationToken;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
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
        
        return view('auth.register', [
            "token" => $token
        ]);
    }
    
    /**
     * Gère l'inscription d'un nouvel utilisateur
     * Par défaut, tous les nouveaux utilisateurs sont enregistrés comme des élèves.
     * Seul un administrateur peut créer d'autres types de comptes.
     */
    public function generateToken() 
    {
        $roles = Role::all();
        foreach($roles as $role) {
            InvitationToken::create([
                'token' => Str::random(64),
                'role_id' => $role->id,
                'validity_period' => now()->addDays(7),
            ]);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            //return back()->with("error", "Les mots de passes ne correspondent pas");
            return back()->withErrors($validator)->withInput($request->except('password', 'password_confirmation'));
        }
        
        $role = Role::find("supervisor");
        
        // Par défaut, le rôle est "supervisor" pour les inscriptions publiques
        $user = User::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id , // Rôle fixe pour l'inscription publique
        ]);
        
        // Rediriger vers le tableau de bord des élèves
        return redirect()->route("login")->with('success', 'Compte créé avec succès! Bienvenue dans GestEdu.');
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

        $user = User::where("email", $request->input("email"));

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
    
    
}