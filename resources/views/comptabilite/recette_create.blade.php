@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouvelle Recette</h1>
    <form action="{{ route('recettes.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Libellé</label>
            <input type="text" name="libelle" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Montant</label>
            <input type="number" name="montant" step="0.01" min="0" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Date de recette</label>
            <input type="date" name="date_recette" value="{{ date('Y-m-d') }}" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Caisse</label>
            <select name="caisse_id" class="form-input w-full" required>
                <option value="">Sélectionner une caisse</option>
                @foreach($caisses as $caisse)
                    <option value="{{ $caisse->id }}">{{ $caisse->nom }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">Enregistrer</button>
    </form>
</div>
@endsection
