<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Support\Carbon;

class NotificationComposer
{
    public function compose(View $view)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $notifications = [];

        if (!$user) {
            $view->with('notifications', $notifications);
            return;
        }

        // ADMIN, VENDEUR, GESTIONNAIRE
        $role = $user->role ?? null;
        $isAdmin = method_exists($user, 'isAdmin') ? $user->isAdmin() : ($role === 'admin');
        $isVendeur = method_exists($user, 'isVendeur') ? $user->isVendeur() : ($role === 'vendeur');
        $isGestionnaire = method_exists($user, 'isGestionnaire') ? $user->isGestionnaire() : ($role === 'gestionnaire');
        $ownerId = method_exists($user, 'getOwnerId') ? $user->getOwnerId() : $user->id;
        if ($isAdmin || $isVendeur || $isGestionnaire) {
            // Rupture de stock (produits dont le stock réel <= stock_minimum)
            $rupture = Produit::where('user_id', $ownerId)->get()->filter(function($produit) {
                return method_exists($produit, 'stockActuel') && $produit->stockActuel() <= $produit->stock_minimum;
            });
            foreach ($rupture as $produit) {
                $notifications[] = "Rupture de stock sur : {$produit->nom_produit}";
            }
            // Produits proches de la date d'expiration (ex: 7 jours)
            $expirationProche = Produit::where('user_id', $ownerId)->with('stocks')->get()->filter(function($produit) {
                foreach ($produit->stocks as $stock) {
                    if ($stock->date_peremption && Carbon::parse($stock->date_peremption)->isBetween(now(), now()->addDays(7))) {
                        return true;
                    }
                }
                return false;
            });
            foreach ($expirationProche as $produit) {
                $notifications[] = "Expiration proche pour : {$produit->nom_produit}";
            }
            // Fin d'abonnement
            if ($user->date_fin_abonnement) {
                $fin = $user->date_fin_abonnement instanceof Carbon ? $user->date_fin_abonnement : Carbon::parse($user->date_fin_abonnement);
                if ($fin->diffInDays(now(), false) >= 0 && $fin->diffInDays(now()) <= 7) {
                    $notifications[] = "Votre abonnement expire bientôt !";
                }
            }
        }
        // SUPER ADMIN
        $isSuperAdmin = method_exists($user, 'isSuperAdmin') ? $user->isSuperAdmin() : ($user->is_super_admin ?? false);
        if ($isSuperAdmin) {
            $admins = User::where('role', 'admin')
                ->where('date_fin_abonnement', '>=', now())
                ->where('date_fin_abonnement', '<=', now()->addDays(7))
                ->get();
            foreach ($admins as $admin) {
                $notifications[] = "Abonnement de l'admin {$admin->name} expire bientôt !";
            }
        }
        $view->with('notifications', $notifications);
    }
}
