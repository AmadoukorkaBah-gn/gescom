@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-2xl mx-auto bg-white shadow-sm rounded-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier un retour</h1>
        <form action="{{ route('retours.update', $retour->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vente</label>
                <select name="vente_id" required class="w-full border-gray-300 rounded px-3 py-2">
                    @foreach($ventes as $vente)
                        <option value="{{ $vente->id }}" {{ $retour->vente_id == $vente->id ? 'selected' : '' }}>Vente #{{ $vente->id }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Produit</label>
                <select name="produit_id" required class="w-full border-gray-300 rounded px-3 py-2">
                    @foreach($produits as $produit)
                        <option value="{{ $produit->id }}" {{ $retour->produit_id == $produit->id ? 'selected' : '' }}>{{ $produit->nom_produit }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                <input type="number" name="quantite" value="{{ $retour->quantite }}" required min="1" class="w-full border-gray-300 rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Raison</label>
                <input type="text" name="raison" value="{{ $retour->raison }}" required class="w-full border-gray-300 rounded px-3 py-2">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded shadow hover:bg-yellow-600 transition">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
