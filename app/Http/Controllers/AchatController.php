<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\AchatDetail;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\MouvementStock;
use App\Models\Stock;
use App\Models\Caisse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AchatController extends Controller
{
    /**
     * Liste des achats
     */
    public function index()
    {
        $ownerId = Auth::user()->getOwnerId();
        $achats = Achat::where('user_id', $ownerId)
            ->with('fournisseur')
            ->orderBy('date_achat', 'desc')
            ->paginate(10);

        return view('achats.index', compact('achats'));
    }

    /**
     * Formulaire de création
     */
public function create()
{
    $ownerId = Auth::user()->getOwnerId();

    $fournisseurs = Fournisseur::where('user_id', $ownerId)
        ->orderBy('nom_fournisseur')
        ->get();

    $produits = Produit::where('user_id', $ownerId)
        ->orderBy('nom_produit')
        ->get();

    $categories = \App\Models\Categorie::where('user_id', $ownerId)
        ->orderBy('nom_categorie')
        ->get();

    return view('achats.create', compact(
        'fournisseurs',
        'produits',
        'categories'
    ));
}

    /**
     * Enregistrer un achat (sans stock)
     */
    public function store(Request $request)
    {
        $request->validate([
            'fournisseur_id'         => 'required|exists:fournisseurs,id',
            'date_achat'            => 'required|date',
            'numero_facture'        => 'nullable|string',
            'items'                 => 'required|array|min:1',
            'items.*.produit_id'    => 'required|exists:produits,id',
            'items.*.quantite'      => 'required|integer|min:1',
            'items.*.prix_unitaire' => 'required|numeric|min:0',
            'items.*.date_peremption' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request) {

            $total = collect($request->items)
                ->sum(fn($item) => $item['quantite'] * $item['prix_unitaire']);

            $achat = Achat::create([
                'user_id'        => Auth::user()->getOwnerId(),
                'fournisseur_id' => $request->fournisseur_id,
                'date_achat'     => $request->date_achat,
                'numero_facture' => $request->numero_facture,
                'total'          => $total,
                'statut'         => 'en_cours',
            ]);

            foreach ($request->items as $item) {
                AchatDetail::create([
                    'achat_id'       => $achat->id,
                    'produit_id'     => $item['produit_id'],
                    'quantite'       => $item['quantite'],
                    'prix_unitaire'  => $item['prix_unitaire'],
                    'date_peremption' => $item['date_peremption'],
                ]);
            }
        });

        return redirect()->route('achats.index')
            ->with('success', 'Achat enregistré avec succès.');
    }

    /**
     * Détails d'un achat
     */
    public function show(Achat $achat)
    {
        $achat->load('fournisseur', 'details.produit');
        return view('achats.show', compact('achat'));
    }

    /**
     * Supprimer un achat
     */
    public function destroy(Achat $achat)
    {
        if ($achat->statut !== 'en_cours') {
            return back()->with('error', 'Impossible de supprimer un achat déjà reçu.');
        }

        $achat->delete();

        return redirect()->route('achats.index')
            ->with('success', 'Achat supprimé.');
    }

    /**
     * Afficher le formulaire de réception avec choix de caisse
     */
    public function showReceiveForm(Achat $achat)
    {
        if ($achat->statut !== 'en_cours') {
            return back()->with('error', 'Achat déjà reçu.');
        }

        $achat->load('details.produit', 'fournisseur');
        $caisses = Caisse::where('user_id', Auth::user()->getOwnerId())->orderBy('nom')->get();

        return view('achats.receive', compact('achat', 'caisses'));
    }

    /**
     * Réception de l'achat → entrée stock + péremption + paiement optionnel
     */
    public function receive(Request $request, Achat $achat)
    {
        if ($achat->statut !== 'en_cours') {
            return back()->with('error', 'Achat déjà reçu.');
        }

        $request->validate([
            'type_paiement' => 'required|in:comptant,credit,partiel',
            'caisse_id' => 'required_if:type_paiement,comptant,partiel|nullable|exists:caisses,id',
            'montant_paye' => 'required_if:type_paiement,partiel|nullable|numeric|min:0',
        ]);

        $typePaiement = $request->type_paiement;
        $montantPaye = 0;
        $caisse = null;

        if ($typePaiement === 'comptant') {
            $caisse = Caisse::find($request->caisse_id);
            $montantPaye = $achat->total;
            
            if ($caisse->solde < $montantPaye) {
                return back()->with('error', 'Solde insuffisant dans la caisse. Solde actuel: ' . number_format($caisse->solde, 2) . ' GNF')->withInput();
            }
        } elseif ($typePaiement === 'partiel') {
            $caisse = Caisse::find($request->caisse_id);
            $montantPaye = $request->montant_paye;
            
            if ($montantPaye > $achat->total) {
                return back()->with('error', 'Le montant ne peut pas dépasser le total de l\'achat.')->withInput();
            }
            
            if ($caisse && $caisse->solde < $montantPaye) {
                return back()->with('error', 'Solde insuffisant dans la caisse. Solde actuel: ' . number_format($caisse->solde, 2) . ' GNF')->withInput();
            }
        }
        // Si crédit, montantPaye reste 0

        DB::transaction(function () use ($achat, $caisse, $montantPaye, $typePaiement, $request) {

            // Mettre à jour le statut de réception
            $achat->update(['statut' => 'recu']);

            foreach ($achat->details as $detail) {
                // Création du lot de stock
                Stock::create([
                    'produit_id'      => $detail->produit_id,
                    'quantite'        => $detail->quantite,
                    'date_peremption' => $detail->date_peremption,
                    'date_entree'     => now(),
                ]);

                // Historique mouvement
                MouvementStock::create([
                    'produit_id'     => $detail->produit_id,
                    'type_mouvement' => 'entree',
                    'quantite'       => $detail->quantite,
                    'date_mouvement' => now(),
                    'raison'         => 'achat',
                ]);
            }

            // Si paiement (comptant ou partiel)
            if ($montantPaye > 0 && $caisse) {
                // Créer la dépense
                $depense = \App\Models\Depense::create([
                    'libelle' => 'Paiement achat #' . $achat->id,
                    'montant' => $montantPaye,
                    'date_depense' => now(),
                    'caisse_id' => $caisse->id,
                    'user_id' => Auth::user()->getOwnerId(),
                ]);

                // Créer le paiement associé
                \App\Models\PaiementAchat::create([
                    'achat_id' => $achat->id,
                    'caisse_id' => $caisse->id,
                    'montant_paye' => $montantPaye,
                    'date_paiement' => now(),
                    'mode' => 'especes',
                    'note' => 'Paiement à la réception',
                ]);

                // Débiter la caisse
                $caisse->debiter($montantPaye);
            }

            // Mettre à jour le statut de paiement
            $achat->updateStatutPaiement();
        });

        $message = 'Achat reçu et stock mis à jour.';
        if ($montantPaye > 0) {
            $message .= ' Caisse débitée de ' . number_format($montantPaye, 2) . ' GNF.';
        }
        if ($typePaiement === 'credit') {
            $message .= ' Achat enregistré à crédit.';
        } elseif ($typePaiement === 'partiel') {
            $reste = $achat->total - $montantPaye;
            $message .= ' Reste à payer: ' . number_format($reste, 2) . ' GNF.';
        }

        return redirect()->route('achats.index')->with('success', $message);
    }
/**
 * Création rapide d'un fournisseur depuis la page achat
 */
public function ajaxFournisseur(Request $request)
{
    $ownerId = Auth::user()->getOwnerId();

    $validated = $request->validate([
        'nom_fournisseur'     => 'required|string|max:255',
        'email'               => 'nullable|email|max:255',
        'contact_fournisseur' => 'nullable|string|max:255',
        'adresse_fournisseur' => 'nullable|string|max:255',
    ]);

    $fournisseur = Fournisseur::create([
        'user_id'             => $ownerId,
        'nom_fournisseur'     => $validated['nom_fournisseur'],
        'email'               => $validated['email'] ?? null,
        'contact_fournisseur' => $validated['contact_fournisseur'] ?? null,
        'adresse_fournisseur' => $validated['adresse_fournisseur'] ?? null,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Fournisseur ajouté avec succès.',
        'fournisseur' => [
            'id' => $fournisseur->id,
            'nom' => $fournisseur->nom_fournisseur,
        ],
    ]);
}


/**
 * Création rapide d'un produit depuis la page achat
 */
public function ajaxProduit(Request $request)
{
    $ownerId = Auth::user()->getOwnerId();

    $validated = $request->validate([
        'nom_produit'    => 'required|string|max:255',
        'categorie_id'   => 'required|exists:categories,id',
        'fournisseur_id' => 'nullable|exists:fournisseurs,id',
        'prix_produit'   => 'required|numeric|min:0',
        'prix_vente'     => 'required|numeric|min:0',
        'stock_minimum'  => 'required|integer|min:0',
        'statut'         => 'required|boolean',
    ]);

    $produit = Produit::create([
        'user_id'        => $ownerId,
        'nom_produit'    => $validated['nom_produit'],
        'categorie_id'   => $validated['categorie_id'],
        'fournisseur_id' => $validated['fournisseur_id'] ?? null,
        'prix_produit'   => $validated['prix_produit'],
        'prix_vente'     => $validated['prix_vente'],
        'stock_minimum'  => $validated['stock_minimum'],
        'statut'         => $validated['statut'],
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Produit ajouté avec succès.',
        'produit' => [
            'id' => $produit->id,
            'nom' => $produit->nom_produit,
        ],
    ]);
}


}
