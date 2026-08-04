@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier la Recette</h1>
        
        <form action="{{ route('recettes.update', $recette->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Libellé</label>
                <input type="text" name="libelle" value="{{ old('libelle', $recette->libelle) }}" 
                       class="form-input w-full border rounded px-3 py-2 @error('libelle') border-red-500 @enderror" required>
                @error('libelle')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Montant (GNF)</label>
                <input type="number" name="montant" step="0.01" min="0.01" value="{{ old('montant', $recette->montant) }}" 
                       class="form-input w-full border rounded px-3 py-2 @error('montant') border-red-500 @enderror" required>
                @error('montant')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Date</label>
                <input type="date" name="date_recette" value="{{ old('date_recette', $recette->date_recette->format('Y-m-d')) }}" 
                       class="form-input w-full border rounded px-3 py-2 @error('date_recette') border-red-500 @enderror" required>
                @error('date_recette')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Caisse</label>
                <select name="caisse_id" class="form-select w-full border rounded px-3 py-2 @error('caisse_id') border-red-500 @enderror" required>
                    @foreach($caisses as $caisse)
                        <option value="{{ $caisse->id }}" {{ old('caisse_id', $recette->caisse_id) == $caisse->id ? 'selected' : '' }}>
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
                    Mettre à jour
                </button>
                <a href="{{ route('recettes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
