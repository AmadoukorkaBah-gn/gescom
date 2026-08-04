@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouvelle Recette</h1>
        
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <form action="{{ route('recettes.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            
            @if(isset($vente))
                <input type="hidden" name="vente_id" value="{{ $vente->id }}">
                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                    <h3 class="font-semibold text-gray-800 mb-2">Paiement pour la vente N°{{ $vente->id }}</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div><strong>Client:</strong></div>
                        <div>{{ $vente->client->nom_client ?? '-' }}</div>
                        <div><strong>Total vente:</strong></div>
                        <div>{{ number_format($vente->montant_total, 2) }} GNF</div>
                        <div><strong>Déjà payé:</strong></div>
                        <div class="text-green-600">{{ number_format($vente->paiements->sum('montant_paye'), 2) }} GNF</div>
                        <div><strong>Reste à payer:</strong></div>
                        <div class="text-red-600 font-bold">{{ number_format($vente->montant_total - $vente->paiements->sum('montant_paye'), 2) }} GNF</div>
                    </div>
                </div>
            @endif
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Libellé</label>
                <input type="text" name="libelle" value="{{ old('libelle', isset($vente) ? 'Paiement vente #' . $vente->id : '') }}" 
                       class="form-input w-full border rounded px-3 py-2 @error('libelle') border-red-500 @enderror" 
                       placeholder="Ex: Vente au comptant, Remboursement..." required>
                @error('libelle')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Montant (GNF)</label>
                <input type="number" name="montant" step="0.01" min="0.01" 
                       value="{{ old('montant', isset($vente) ? $vente->montant_total - $vente->paiements->sum('montant_paye') : '') }}" 
                       class="form-input w-full border rounded px-3 py-2 @error('montant') border-red-500 @enderror" required>
                @error('montant')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            @if(isset($vente))
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Mode de paiement</label>
                <select name="mode" class="form-select w-full border rounded px-3 py-2" required>
                    <option value="especes">Espèces</option>
                    <option value="mobile_money">Mobile Money</option>
                    <option value="cheque">Chèque</option>
                    <option value="virement">Virement</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
            @endif
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Date</label>
                <input type="date" name="date_recette" value="{{ old('date_recette', now()->format('Y-m-d\TH:i')) }}" 
                       class="form-input w-full border rounded px-3 py-2 @error('date_recette') border-red-500 @enderror" required>
                @error('date_recette')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Caisse</label>
                <select name="caisse_id" class="form-select w-full border rounded px-3 py-2 @error('caisse_id') border-red-500 @enderror" required>
                    <option value="">-- Sélectionner une caisse --</option>
                    @foreach($caisses as $caisse)
                        <option value="{{ $caisse->id }}" {{ old('caisse_id') == $caisse->id ? 'selected' : '' }}>
                            {{ $caisse->nom }} ({{ number_format($caisse->solde, 2) }} GNF)
                        </option>
                    @endforeach
                </select>
                @error('caisse_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex space-x-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                    Enregistrer
                </button>
                <a href="{{ route('recettes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
