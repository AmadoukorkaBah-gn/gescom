<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Exclure les routes d'authentification et super admin
        $excludedRoutes = [
            'login', 
            'register', 
            'logout', 
            'password.*', 
            'verification.*', 
            'super-admin.*',
            'password.request',
            'password.email',
            'password.reset',
            'password.store',
            'password.confirm',
            'password.update'
        ];
        
        foreach ($excludedRoutes as $pattern) {
            if ($request->routeIs($pattern)) {
                return $next($request);
            }
        }
        
        // Exclure aussi les routes qui commencent par /login, /register, etc.
        $excludedPaths = ['/login', '/register', '/logout', '/forgot-password', '/reset-password'];
        foreach ($excludedPaths as $path) {
            if ($request->is($path) || $request->is($path . '/*')) {
                return $next($request);
            }
        }

        // Si l'utilisateur n'est pas connecté, laisser passer (pour les routes guest)
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
            
            // Le super admin a toujours accès
            if ($user->isSuperAdmin()) {
                return $next($request);
            }

            // Charger la relation parent si nécessaire
            if ($user->parent_id && !$user->relationLoaded('parent')) {
                $user->load('parent');
            }

            // Vérifier si l'abonnement est actif (vérifie aussi le parent admin)
            if (!$user->isAbonnementActif()) {
                // Déconnexion automatique si suspendu ou expiré
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                // Rediriger vers la page de connexion avec message
                $message = 'Votre compte a été suspendu ou votre abonnement a expiré.';
                if ($user->parent_id && $user->parent) {
                    if ($user->parent->statut_abonnement === 'suspendu') {
                        $message = 'L\'administrateur qui vous a créé a été suspendu. Votre accès est bloqué.';
                    } elseif ($user->parent->statut_abonnement === 'expire') {
                        $message = 'L\'abonnement de l\'administrateur qui vous a créé a expiré. Votre accès est bloqué.';
                    }
                }
                
                return redirect()->route('login')->with('error', $message);
            }

        return $next($request);
    }
}
