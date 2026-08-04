<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ownerId = Auth::user()->getOwnerId();
        $query = Fournisseur::where('user_id', $ownerId);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom_fournisseur', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_fournisseur', 'like', "%{$search}%");
            });
        }

        $fournisseurs = $query->paginate(10);
        return view('fournisseurs.index', compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fournisseurs.create'); // Affiche le formulaire de création
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $data = $request->validate([
            'nom_fournisseur' => 'required|string|max:255',
            'email' => 'nullable|email',
            'contact_fournisseur' => 'nullable|string|max:20',
            'adresse_fournisseur' => 'nullable|string|max:255',
        ]);

        $data['user_id'] = Auth::user()->getOwnerId();
        // Création du fournisseur
        Fournisseur::create($data);

        return redirect()->route('fournisseurs.index')
                         ->with('success', 'Fournisseur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        return view('fournisseurs.show', compact('fournisseur'));
    }

    /**
     * Display a printable list of fournisseurs.
     */
    public function print()
    {
        $fournisseurs = Fournisseur::where('user_id', Auth::user()->getOwnerId())->get();
        return view('fournisseurs.print', compact('fournisseurs'));
    }

    /**
     * Export fournisseurs as CSV
     */
    public function exportCsv()
    {
        $filename = 'fournisseurs-'.date('YmdHis').'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $ownerId = Auth::user()->getOwnerId();
        $callback = function () use ($ownerId) {
            $file = fopen('php://output', 'w');
            // Header row
            fputcsv($file, ['ID', 'Nom', 'Email', 'Téléphone', 'Adresse']);

            foreach (Fournisseur::where('user_id', $ownerId)->get() as $f) {
                fputcsv($file, [
                    $f->id,
                    $f->nom_fournisseur,
                    $f->email,
                    $f->contact_fournisseur,
                    $f->adresse_fournisseur,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        return view('fournisseurs.edit', compact('fournisseur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nom_fournisseur' => 'required|string|max:255',
            'email' => 'nullable|email',
            'contact_fournisseur' => 'nullable|string|max:20',
            'adresse_fournisseur' => 'nullable|string|max:255',
        ]);

        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->update($data);

        return redirect()->route('fournisseurs.index')
                         ->with('success', 'Fournisseur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->delete();

        return redirect()->route('fournisseurs.index')
                         ->with('success', 'Fournisseur supprimé avec succès.');
    }
}
