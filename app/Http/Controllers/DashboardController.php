<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use App\Models\SupervisorDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord général et redirige selon le rôle de l'utilisateur
     */
    public function index()
    {
        $user = Auth::user();

        
        switch ($user->role->name) {
            case 'Administrateur':
                return redirect()->route('dashboard.admin');
            case 'Professeur':
                return redirect()->route('dashboard.teacher');
            case 'student':
                return redirect()->route('dashboard.student');
            case 'Parent':
                return redirect()->route('dashboard.parent');
            case 'accountant':
                return redirect()->route('dashboard.accountant');
            default:
                // Si le rôle n'est pas reconnu, on affiche une vue par défaut
                return view('dashboard.index');
        }
    }

    
    
    /**
     * Affiche le tableau de bord administrateur
     */
    public function admin()
    {
        $user = User::find(Auth::user()->id);
        // Vérifie que l'utilisateur est bien un administrateur
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
        }
        
        // Ici, on chargerait les statistiques et données nécessaires pour l'admin
        
        return view('dashboard.admin', [
            "user" => Auth::user(),
        ]);
    }
    
    /**
     * Affiche le tableau de bord enseignant
     */
    public function teacher()
    {
        $user = User::find(Auth::user()->id);
        // Vérifie que l'utilisateur est bien un enseignant
        if (!$user->isTeacher()) {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
        }
        
        // Ici, on chargerait les données spécifiques à l'enseignant connecté
        
        return view('dashboard.teacher', [
            "user" => Auth::user(),
        ]);
    }
    
    /**
     * Affiche le tableau de bord étudiant
     */
    // public function student()
    // {
    //     // Vérifie que l'utilisateur est bien un étudiant
    //     if (!Auth::user()->isStudent()) {
    //         return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
    //     }
        
    //     // Ici, on chargerait les données spécifiques à l'étudiant connecté
        
    //     return view('dashboard.student', [
    //         "user" => Auth::user(),
    //     ]);
    // }
    
    /**
     * Affiche le tableau de bord parent
     */
    public function parent()
    {
        // Vérifie que l'utilisateur est bien un parent
        // if (!Auth::user()->isParent()) {
        //     return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
        // }
        
        // Ici, on chargerait les données spécifiques au parent connecté
        
        return view('dashboard.parent', [
            "user" => Auth::user(),
        ]);
    }

    
    
    /**
     * Affiche le tableau de bord comptable
     */
    public function accountant()
    {
        $user = User::find(Auth::user()->id);
        // Vérifie que l'utilisateur est bien un comptable
        if (!$user->isAccountant()) {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
        }
        
        // Ici, on chargerait les données spécifiques au comptable connecté
        
        return view('dashboard.accountant', [
            "user" => Auth::user(),
        ]);
    }
    
}