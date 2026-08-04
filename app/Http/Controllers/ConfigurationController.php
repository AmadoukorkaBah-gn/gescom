<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ConfigurationController extends Controller
{
    /**
     * Afficher le formulaire de configuration
     */
    public function index()
    {
        $ownerId = Auth::user()->getOwnerId();

        $config = Configuration::where('user_id', $ownerId)->first();

        // Créer une configuration par défaut si elle n'existe pas
        if (!$config) {
            $config = Configuration::create([
                'user_id' => $ownerId,
                'nom_entreprise' => '',
                'contact' => null,
                'email_entreprise' => null,
                'adresse' => null,
                'couleur_primaire' => '#1e293b',
                'couleur_secondaire' => '#3b82f6',
                'logo' => null,
            ]);
        }

        return view('parametres.configuration.index', compact('config'));
    }

    /**
     * Mettre à jour la configuration
     */
    public function update(Request $request)
    {
        $request->validate([
            'nom_entreprise' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:50',
            'email_entreprise' => 'nullable|email|max:255',
            'adresse' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $ownerId = Auth::user()->getOwnerId();

        $config = Configuration::where('user_id', $ownerId)->first();

        // Créer la configuration si elle n'existe pas
        if (!$config) {
            $config = Configuration::create([
                'user_id' => $ownerId,
            ]);
        }

        $data = $request->only([
            'nom_entreprise',
            'contact',
            'email_entreprise',
            'adresse',
        ]);

        // Gestion du logo
        if ($request->hasFile('logo')) {

            // Supprimer l'ancien logo s'il existe
            if ($config->logo && Storage::disk('public')->exists($config->logo)) {
                Storage::disk('public')->delete($config->logo);
            }

            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $config->update($data);

        return redirect()
            ->route('configuration.index')
            ->with('success', 'Configuration mise à jour avec succès.');
    }

    /**
     * Supprimer le logo
     */
    public function deleteLogo()
    {
        $ownerId = Auth::user()->getOwnerId();

        $config = Configuration::where('user_id', $ownerId)->first();

        if ($config && $config->logo) {

            if (Storage::disk('public')->exists($config->logo)) {
                Storage::disk('public')->delete($config->logo);
            }

            $config->update(['logo' => null]);
        }

        return redirect()
            ->route('configuration.index')
            ->with('success', 'Logo supprimé avec succès.');
    }
}
