<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaisseController extends Controller
{
    public function index()
    {
        $caisses = Caisse::where('user_id', Auth::user()->getOwnerId())->orderBy('nom')->get();
        return view('comptabilite.caisses.index', compact('caisses'));
    }

    public function create()
    {
        return view('comptabilite.caisses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'solde' => 'required|numeric|min:0',
        ]);

        Caisse::create([
            'user_id' => Auth::user()->getOwnerId(),
            'nom' => $request->nom,
            'solde' => $request->solde,
        ]);

        return redirect()->route('caisses.index')->with('success', 'Caisse créée avec succès.');
    }

    public function show(Caisse $caisse)
    {
        $caisse->load(['recettes' => function($q) {
            $q->orderBy('date_recette', 'desc')->limit(10);
        }, 'depenses' => function($q) {
            $q->orderBy('date_depense', 'desc')->limit(10);
        }]);

        return view('comptabilite.caisses.show', compact('caisse'));
    }

    public function edit(Caisse $caisse)
    {
        return view('comptabilite.caisses.edit', compact('caisse'));
    }

    public function update(Request $request, Caisse $caisse)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'solde' => 'required|numeric|min:0',
        ]);

        $caisse->update($request->only('nom', 'solde'));

        return redirect()->route('caisses.index')->with('success', 'Caisse mise à jour avec succès.');
    }

    public function destroy(Caisse $caisse)
    {
        if ($caisse->recettes()->count() > 0 || $caisse->depenses()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une caisse avec des recettes ou dépenses.');
        }

        $caisse->delete();

        return redirect()->route('caisses.index')->with('success', 'Caisse supprimée avec succès.');
    }
}
