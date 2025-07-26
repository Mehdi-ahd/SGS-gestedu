<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ParentIdentityVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Vérifier si l'utilisateur est connecté et est un parent
        if (!$user || $user->role_id !== 'supervisor') {
            return redirect()->route('login');
        }

        // Si le parent a le statut "en attente de soumission"
        if ($user->status === 'en attente de soumission') {
            // Permettre uniquement l'accès à la page de vérification
            $allowedRoutes = [
                'parent.verification',
                'storeVerification'
            ];
            
            // Vérifier si la route actuelle est autorisée
            if (!in_array($request->route()->getName(), $allowedRoutes)) {
                // Rediriger vers la page de vérification avec un message
                return redirect()->route('parent.verification')
                    ->with('warning', 'Vous devez compléter votre vérification d\'identité pour accéder à cette page.');
            }
        }

        return $next($request);
    }
}
