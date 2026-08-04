@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouvelle Caisse</h1>
        
        <form action="{{ route('caisses.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nom de la caisse</label>
                <input type="text" name="nom" value="{{ old('nom') }}" 
                       class="form-input w-full border rounded px-3 py-2 @error('nom') border-red-500 @enderror" required>
                @error('nom')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Solde initial (GNF)</label>
                <input type="number" name="solde" step="0.01" min="0" value="{{ old('solde', 0) }}" 
                       class="form-input w-full border rounded px-3 py-2 @error('solde') border-red-500 @enderror" required>
                @error('solde')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex space-x-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                    Enregistrer
                </button>
                <a href="{{ route('caisses.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
