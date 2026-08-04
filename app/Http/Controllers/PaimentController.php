<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Vente;
use App\Models\Caisse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaimentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ownerId = Auth::user()->getOwnerId();
        $paiements = Paiement::with('vente.client')
            ->whereHas('vente', fn($q) => $q->where('user_id', $ownerId))
            ->orderBy('date_paiement', 'desc')
            ->paginate(15);

        return view('paiement.index', compact('paiements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $vente_id = $request->query('vente_id');
        $caisses = Caisse::where('user_id', Auth::user()->getOwnerId())->orderBy('nom')->get();
        return view('paiement.create', compact('vente_id', 'caisses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vente_id' => 'required|exists:ventes,id',
            'montant_paye' => 'required|numeric|min:0.01',
            'date_paiement' => 'required|date',
            'mode' => 'required|string',
            'caisse_id' => 'required|exists:caisses,id',
        ]);

        $paiement = Paiement::create($validated);

        // Créditer la caisse (argent reçu de la vente)
        $caisse = Caisse::find($validated['caisse_id']);
        $caisse->crediter($validated['montant_paye']);

        // Mettre à jour le statut de la vente
        $vente = Vente::with('paiements')->find($validated['vente_id']);
        $totalPaye = $vente->paiements->sum('montant_paye');
        if ($totalPaye >= $vente->montant_total) {
            $vente->statut = 'payé';
        } elseif ($totalPaye > 0) {
            $vente->statut = 'partiel';
        } else {
            $vente->statut = 'en_cours';
        }
        $vente->save();

        return redirect()->route('ventes.index')->with('success', 'Paiement enregistré et caisse mise à jour.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
