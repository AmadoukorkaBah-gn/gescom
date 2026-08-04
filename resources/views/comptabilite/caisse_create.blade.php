@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouvelle Caisse</h1>
    <form action="{{ route('caisses.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nom de la caisse</label>
            <input type="text" name="nom" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Solde initial</label>
            <input type="number" name="solde" step="0.01" min="0" class="form-input w-full" required>
        </div>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">Enregistrer</button>
    </form>
</div>
@endsection
