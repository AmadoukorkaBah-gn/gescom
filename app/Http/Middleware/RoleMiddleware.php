<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        if (!$user || !$user->role) {
            abort(403, 'Accès refusé');
        }
        // Normaliser le rôle de l'utilisateur (minuscule, sans espace)
        $userRole = strtolower(trim($user->role));
        // Normaliser les rôles autorisés
        $allowedRoles = array_map(function($r) {
            return strtolower(trim($r));
        }, $roles);
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Accès refusé');
        }
        return $next($request);
    }
}
