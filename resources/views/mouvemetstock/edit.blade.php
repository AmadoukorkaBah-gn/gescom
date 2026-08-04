@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le Mouvement</h1>

    <form action="{{ route('mouvement.update', $mouvement) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="produit_id" class="block text-sm font-medium text-gray-700">Produit</label>
                    <select name="produit_id" id="produit_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @foreach(\App\Models\Produit::all() as $p)
                            <option value="{{ $p->id }}" {{ $mouvement->produit_id == $p->id ? 'selected' : '' }}>{{ $p->nom_produit }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="type_mouvement" class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type_mouvement" id="type_mouvement" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="entree" {{ $mouvement->type_mouvement == 'entree' ? 'selected' : '' }}>Entrée</option>
                        <option value="sortie" {{ $mouvement->type_mouvement == 'sortie' ? 'selected' : '' }}>Sortie</option>
                    </select>
                </div>

                <div>
                    <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité</label>
                    <input type="number" name="quantite" id="quantite" value="{{ $mouvement->quantite }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="raison" class="block text-sm font-medium text-gray-700">Raison</label>
                    <select name="raison" id="raison" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="achat" {{ $mouvement->raison == 'achat' ? 'selected' : '' }}>Achat</option>
                        <option value="vente" {{ $mouvement->raison == 'vente' ? 'selected' : '' }}>Vente</option>
                        <option value="retour" {{ $mouvement->raison == 'retour' ? 'selected' : '' }}>Retour</option>
                    </select>
                </div>

                <div>
                    <label for="date_mouvement" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="datetime-local" name="date_mouvement" id="date_mouvement" value="{{ $mouvement->date_mouvement ? $mouvement->date_mouvement->format('Y-m-d\TH:i') : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Mettre à jour
                </button>
                <a href="{{ route('mouvement.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">Annuler</a>
            </div>
        </div>
    </form>
</div>
@endsection