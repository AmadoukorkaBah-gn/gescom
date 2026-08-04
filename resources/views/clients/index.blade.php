@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Liste des Clients</h1>
        <div class="flex space-x-2">
            <a href="{{ route('clients.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Ajouter un Client
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <!-- En-tête orange -->
            <thead class="bg-orange-500">
                <tr>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">N°</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Nom</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Contact</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Adresse</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <!-- Corps du tableau -->
            <tbody class="bg-white divide-y divide-gray-200 text-gray-900 font-bold">
                @forelse($clients as $client)
                <tr class="hover:bg-gray-50">
                    <td class="px-2 py-2 text-sm">{{ $loop->iteration }}</td>
                    <td class="px-2 py-2 text-sm">{{ $client->nom_client }}</td>
                    <td class="px-2 py-2 text-sm">{{ $client->contact_client }}</td>
                    <td class="px-2 py-2 text-sm">{{ $client->adresse_client }}</td>
                    <td class="px-2 py-2 text-sm flex space-x-1">
                        <a href="{{ route('clients.show', $client->id) }}" 
                           class="bg-indigo-500 hover:bg-indigo-600 text-white px-2 py-1 rounded flex items-center">
                           <i class="fas fa-eye mr-1"></i> Voir
                        </a>
                        <a href="{{ route('clients.edit', $client->id) }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded flex items-center">
                           <i class="fas fa-edit mr-1"></i> Éditer
                        </a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded flex items-center"
                                onclick="return confirm('Voulez-vous vraiment supprimer ce client ?')">
                                <i class="fas fa-trash mr-1"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-2 py-2 text-center text-sm text-gray-500">Aucun client trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $clients->links() }}
    </div>
</div>
@endsection
