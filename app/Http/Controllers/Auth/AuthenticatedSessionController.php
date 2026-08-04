<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();
        
        // Charger la relation parent si nécessaire
        if ($user->parent_id && !$user->relationLoaded('parent')) {
            $user->load('parent');
        }
        
        // Vérifier si l'utilisateur ou son parent admin est suspendu/expiré
        if (!$user->isSuperAdmin() && !$user->isAbonnementActif()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
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

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
