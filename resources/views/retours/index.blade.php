@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Liste des retours</h1>
            <a href="{{ route('retours.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 transition">Ajouter un retour</a>
        </div>
        <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Vente</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Quantité</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Raison</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($retours as $retour)
                    <tr>
                        <td class="px-4 py-2">{{ $retour->id }}</td>
                        <td class="px-4 py-2">{{ $retour->produit->nom_produit }}</td>
                        <td class="px-4 py-2">#{{ $retour->vente->id }}</td>
                        <td class="px-4 py-2">{{ $retour->quantite }}</td>
                        <td class="px-4 py-2">{{ $retour->raison }}</td>
                        <td class="px-4 py-2">{{ $retour->date_retour }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('retours.edit', $retour->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition">Modifier</a>
                            <form action="{{ route('retours.destroy', $retour->id) }}" method="POST" onsubmit="return confirm('Supprimer ce retour ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
