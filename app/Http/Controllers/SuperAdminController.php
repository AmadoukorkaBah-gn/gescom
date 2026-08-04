<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    /**
     * Tableau de bord du super admin
     */
    public function dashboard()
    {
        // Nombre total d'admins créés par le super admin (parent_id = null, is_super_admin = false, role = 'admin')
        $totalClients = User::where('role', 'admin')
            ->where('is_super_admin', false)
            ->whereNull('parent_id')
            ->count();
        
        // Admins actifs (créés par le super admin)
        $adminsActifs = User::where('is_super_admin', false)
            ->where('role', 'admin')
            ->whereNull('parent_id')
            ->where('statut_abonnement', 'actif')
            ->where(function($q) {
                $q->whereNull('date_fin_abonnement')
                  ->orWhere('date_fin_abonnement', '>=', now());
            })
            ->count();

        // Abonnements actifs (admins créés par le super admin)
        $abonnesActifs = User::where('is_super_admin', false)
            ->where('role', 'admin')
            ->whereNull('parent_id')
            ->where('statut_abonnement', 'actif')
            ->where(function($q) {
                $q->whereNull('date_fin_abonnement')
                  ->orWhere('date_fin_abonnement', '>=', now());
            })
            ->count();

        // Abonnements expirés (admins créés par le super admin)
        $abonnesExpires = User::where('is_super_admin', false)
            ->where('role', 'admin')
            ->whereNull('parent_id')
            ->where(function($q) {
                $q->where('statut_abonnement', 'expire')
                  ->orWhere(function($q2) {
                      $q2->where('statut_abonnement', 'actif')
                         ->where('date_fin_abonnement', '<', now());
                  });
            })
            ->count();

        // Abonnements en attente (admins créés par le super admin)
        $abonnesEnAttente = User::where('is_super_admin', false)
            ->where('role', 'admin')
            ->whereNull('parent_id')
            ->whereNull('abonnement_type')
            ->count();
        
        // Revenus aujourd'hui
        $revenuAujourdhui = \App\Models\PaiementAbonnement::whereDate('date_paiement', today())
            ->sum('montant');
        
        // Revenus ce mois
        $revenuCeMois = \App\Models\PaiementAbonnement::whereMonth('date_paiement', now()->month)
            ->whereYear('date_paiement', now()->year)
            ->sum('montant');
        
        // Revenus total
        $revenuTotal = \App\Models\PaiementAbonnement::sum('montant');
        
        // Évolution des abonnements (12 derniers mois)
        $evolutionAbonnements = User::where('is_super_admin', false)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mois, COUNT(*) as total')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get()
            ->map(function($item) {
                return [
                    'mois' => $item->mois,
                    'total' => (int)$item->total
                ];
            });
        
        // Revenu mensuel (12 derniers mois)
        $revenuMensuel = \App\Models\PaiementAbonnement::selectRaw('DATE_FORMAT(date_paiement, "%Y-%m") as mois, SUM(montant) as total')
            ->where('date_paiement', '>=', now()->subMonths(12))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get()
            ->map(function($item) {
                return [
                    'mois' => $item->mois,
                    'total' => (float)$item->total
                ];
            });
        
        // Alertes : Abonnements expirés
        $alertesAbonnementsExpires = User::where('is_super_admin', false)
            ->where(function($q) {
                $q->where('statut_abonnement', 'expire')
                  ->orWhere(function($q2) {
                      $q2->where('statut_abonnement', 'actif')
                         ->where('date_fin_abonnement', '<', now());
                  });
            })
            ->orderBy('date_fin_abonnement', 'asc')
            ->limit(10)
            ->get();
        
        // Alertes : Paiements en retard (abonnements expirés depuis plus de 7 jours)
        $alertesPaiementsRetard = User::where('is_super_admin', false)
            ->where(function($q) {
                $q->where('statut_abonnement', 'expire')
                  ->orWhere(function($q2) {
                      $q2->where('statut_abonnement', 'actif')
                         ->where('date_fin_abonnement', '<', now()->subDays(7));
                  });
            })
            ->orderBy('date_fin_abonnement', 'asc')
            ->limit(10)
            ->get();

        return view('super-admin.dashboard', compact(
            'totalClients',
            'adminsActifs',
            'abonnesActifs',
            'abonnesExpires',
            'abonnesEnAttente',
            'revenuAujourdhui',
            'revenuCeMois',
            'revenuTotal',
            'evolutionAbonnements',
            'revenuMensuel',
            'alertesAbonnementsExpires',
            'alertesPaiementsRetard'
        ));
    }

    /**
     * Créer un nouvel admin
     */
    public function createAdmin()
    {
        return view('super-admin.create-admin');
    }

    /**
     * Enregistrer un nouvel admin
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
            'is_super_admin' => false,
            'parent_id' => null, // Un admin est une entreprise indépendante
            'statut_abonnement' => 'actif',
        ]);

        return redirect()->route('super-admin.admins.index')->with('success', 'Admin créé avec succès.');
    }

    /**
     * Activer/Renouveler un abonnement
     */
    public function updateAbonnement(Request $request, User $user)
    {
        $request->validate([
            'abonnement_type' => 'required|in:mensuel,trimestriel,annuel',
            'mode' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $dateDebut = now();
        $dateFin = $user->calculerDateFinAbonnement($request->abonnement_type);

        \Illuminate\Support\Facades\DB::transaction(function () use ($user, $request, $dateDebut, $dateFin) {
            // Mettre à jour l'abonnement
            $user->update([
                'abonnement_type' => $request->abonnement_type,
                'date_debut_abonnement' => $dateDebut,
                'date_fin_abonnement' => $dateFin,
                'statut_abonnement' => 'actif',
            ]);

            // Enregistrer le paiement
            $montant = $this->getMontantAbonnement($request->abonnement_type);
            \App\Models\PaiementAbonnement::create([
                'user_id' => $user->id,
                'montant' => $montant,
                'date_paiement' => now(),
                'mode' => $request->mode ?? 'especes',
                'abonnement_type' => $request->abonnement_type,
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'note' => $request->note ?? null,
            ]);
        });

        return redirect()->route('super-admin.abonnements.index')->with('success', 'Abonnement activé/renouvelé avec succès.');
    }

    /**
     * Suspendre un utilisateur
     */
    public function suspendre(User $user)
    {
        if ($user->is_super_admin) {
            return back()->with('error', 'Impossible de suspendre le super administrateur.');
        }

        $user->update(['statut_abonnement' => 'suspendu']);

        return redirect()->route('super-admin.dashboard')->with('success', 'Utilisateur suspendu avec succès.');
    }

    /**
     * Réactiver un utilisateur
     */
    public function reactiver(User $user)
    {
        if ($user->is_super_admin) {
            return back()->with('error', 'Impossible de modifier le super administrateur.');
        }

        // Si l'abonnement est expiré, on le réactive avec la date de fin existante
        if ($user->date_fin_abonnement && $user->date_fin_abonnement->isPast()) {
            // Prolonger de 30 jours si expiré
            $user->update([
                'date_fin_abonnement' => now()->addDays(30),
                'statut_abonnement' => 'actif',
            ]);
        } else {
            $user->update(['statut_abonnement' => 'actif']);
        }

        return redirect()->back()->with('success', 'Utilisateur réactivé avec succès.');
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy(User $user)
    {
        if ($user->is_super_admin) {
            return back()->with('error', 'Impossible de supprimer le super administrateur.');
        }

        $user->delete();

        return redirect()->route('super-admin.dashboard')->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Liste des admins
     */
    public function indexAdmins()
    {
        // On affiche uniquement les vrais admins (parent_id null)
        $admins = User::where('is_super_admin', false)
            ->where('role', 'admin')
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('super-admin.admins.index', compact('admins'));
    }

    /**
     * Modifier un admin
     */
    public function editAdmin(User $user)
    {
        if ($user->is_super_admin) {
            abort(403);
        }
        return view('super-admin.admins.edit', compact('user'));
    }

    /**
     * Mettre à jour un admin
     */
    public function updateAdmin(Request $request, User $user)
    {
        if ($user->is_super_admin) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email');
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('super-admin.admins.index')->with('success', 'Admin mis à jour avec succès.');
    }

    /**
     * Liste des abonnements
     */
    public function indexAbonnements()
    {
        // Seuls les administrateurs créés par le super admin (parent_id null)
        $users = User::where('is_super_admin', false)
            ->where('role', 'admin')
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('super-admin.abonnements.index', compact('users'));
    }

    /**
     * Liste des paiements
     */
    public function indexPaiements()
    {
        $paiements = \App\Models\PaiementAbonnement::with('user')
            ->orderBy('date_paiement', 'desc')
            ->paginate(15);

        return view('super-admin.paiements.index', compact('paiements'));
    }

    /**
     * Obtenir le montant d'un abonnement selon le type
     */
    private function getMontantAbonnement(string $type): float
    {
        // Vous pouvez définir vos propres tarifs ici
        $tarifs = [
            'mensuel' => 50000,
            'trimestriel' => 140000, // 3 mois avec réduction
            'annuel' => 500000, // 12 mois avec réduction
        ];

        return $tarifs[$type] ?? 0;
    }
}
