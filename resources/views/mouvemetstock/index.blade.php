@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Approvisionnements (Achats)</h1>
        <a href="{{ route('mouvement.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nouveau Approvisionnement
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raison</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($mouvements as $m)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $m->produit->nom_produit ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $m->quantite }}</td>
                    <td class="px-4 py-2">{{ $m->raison }}</td>
                    <td class="px-4 py-2">{{ $m->date_mouvement ? $m->date_mouvement->format('Y-m-d H:i') : $m->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('mouvement.show', $m) }}" class="text-blue-600 hover:text-blue-900 mr-2">Voir</a>
                        <a href="{{ route('mouvement.edit', $m) }}" class="text-green-600 hover:text-green-900 mr-2">Modifier</a>
                        <form action="{{ route('mouvement.destroy', $m) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $mouvements->links() }}
        </div>
    </div>
</div>
@endsection
