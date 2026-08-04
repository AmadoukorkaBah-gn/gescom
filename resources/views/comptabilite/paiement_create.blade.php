@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouveau Paiement</h1>
    <form action="{{ route('paiement.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Vente</label>
            <select name="vente_id" class="form-input w-full" required>
                <option value="">Sélectionner une vente</option>
                @foreach($ventes as $vente)
                    <option value="{{ $vente->id }}">#{{ $vente->id }} - {{ $vente->client->nom_client ?? 'Client inconnu' }} ({{ number_format($vente->montant_total,2) }} GNF)</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Montant payé</label>
            <input type="number" name="montant_paye" step="0.01" min="0" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Date de paiement</label>
            <input type="date" name="date_paiement" value="{{ date('Y-m-d') }}" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Mode de paiement</label>
            <select name="mode" class="form-input w-full" required>
                <option value="espèces">Espèces</option>
                <option value="mobile money">Mobile Money</option>
                <option value="carte bancaire">Carte Bancaire</option>
                <option value="chèque">Chèque</option>
            </select>
        </div>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">Enregistrer</button>
    </form>
</div>
@endsection
