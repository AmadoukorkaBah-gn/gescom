<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Liste des utilisateurs créés par l'admin connecté
     */
    public function index()
    {
        // Le super admin ne doit pas voir cette page
        if (Auth::user()->isSuperAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        $ownerId = Auth::user()->getOwnerId();
        // Exclure le super admin de la liste
        $users = User::where('is_super_admin', false)
            ->where(function($q) use ($ownerId) {
                $q->where('parent_id', $ownerId)
                  ->orWhere('id', $ownerId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('parametres.users.index', compact('users'));
    }

    /**
     * Formulaire de création d'un utilisateur
     */
    public function create()
    {
        return view('parametres.users.create');
    }

    /**
     * Enregistrer un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Seul le super admin peut créer des admins
        $allowedRoles = $user->isSuperAdmin() 
            ? ['admin', 'vendeur', 'gestionnaire'] 
            : ['vendeur', 'gestionnaire'];

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:' . implode(',', $allowedRoles),
        ]);

        // Si on essaie de créer un admin sans être super admin
        if ($request->role === 'admin' && !$user->isSuperAdmin()) {
            abort(403, 'Seul le super administrateur peut créer des administrateurs.');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'parent_id' => Auth::user()->getOwnerId(),
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Afficher un utilisateur
     */
    public function show(User $user)
    {
        $ownerId = Auth::user()->getOwnerId();
        // Vérifier que l'utilisateur appartient à l'admin connecté
        if ($user->parent_id !== $ownerId && $user->id !== $ownerId) {
            abort(403);
        }

        return view('parametres.users.show', compact('user'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit(User $user)
    {
        $ownerId = Auth::user()->getOwnerId();
        // Vérifier que l'utilisateur appartient à l'admin connecté
        if ($user->parent_id !== $ownerId && $user->id !== $ownerId) {
            abort(403);
        }

        return view('parametres.users.edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $ownerId = Auth::user()->getOwnerId();
        // Vérifier que l'utilisateur appartient à l'admin connecté
        if ($user->parent_id !== $ownerId && $user->id !== $ownerId) {
            abort(403);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,vendeur,gestionnaire',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6|confirmed';
        }

        $data = $request->validate($rules);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy(User $user)
    {
        $ownerId = Auth::user()->getOwnerId();
        // Vérifier que l'utilisateur appartient à l'admin connecté
        if ($user->parent_id !== $ownerId) {
            abort(403);
        }

        // Ne pas permettre de se supprimer soi-même
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
