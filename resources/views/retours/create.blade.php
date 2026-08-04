@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-2xl mx-auto bg-white shadow-sm rounded-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Ajouter un retour</h1>
        <form action="{{ route('retours.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vente</label>
                <select id="vente_select" name="vente_id" required class="w-full border-gray-300 rounded px-3 py-2">
                    <option value="">-- Sélectionnez une vente --</option>
                    @foreach($ventes as $vente)
                        <option value="{{ $vente->id }}" data-produits='@json($vente->details->map(fn($d) => ["id" => $d->produit->id, "nom" => $d->produit->nom_produit]))'>
                            Vente #{{ $vente->id }} - {{ $vente->client->nom_client }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Produit</label>
                <select id="produit_select" name="produit_id" required class="w-full border-gray-300 rounded px-3 py-2">
                    <option value="">-- Sélectionnez un produit --</option>
                    {{-- Les options seront remplies via JS --}}
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                <input type="number" name="quantite" required min="1" class="w-full border-gray-300 rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Raison</label>
                <input type="text" name="raison" required class="w-full border-gray-300 rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Caisse à débiter (remboursement)</label>
                <select name="caisse_id" required class="w-full border-gray-300 rounded px-3 py-2">
                    <option value="">-- Sélectionnez une caisse --</option>
                    @foreach(\App\Models\Caisse::orderBy('nom')->get() as $caisse)
                        <option value="{{ $caisse->id }}">
                            {{ $caisse->nom }} (Solde: {{ number_format($caisse->solde, 2) }} GNF)
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">Le montant du remboursement sera débité de cette caisse.</p>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700 transition">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

{{-- Script pour mettre à jour la liste des produits selon la vente --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const venteSelect = document.getElementById('vente_select');
        const produitSelect = document.getElementById('produit_select');

        venteSelect.addEventListener('change', function () {
            const selectedOption = venteSelect.selectedOptions[0];
            const produits = selectedOption.dataset.produits ? JSON.parse(selectedOption.dataset.produits) : [];

            // Vider le select des produits
            produitSelect.innerHTML = '<option value="">-- Sélectionnez un produit --</option>';

            // Ajouter les produits disponibles pour cette vente
            produits.forEach(p => {
                const option = document.createElement('option');
                option.value = p.id;
                option.textContent = p.nom;
                produitSelect.appendChild(option);
            });
        });
    });
</script>
@endsection
