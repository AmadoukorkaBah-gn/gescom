@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Liste des Dépenses</h1>
        <a href="{{ route('depenses.create') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
            Nouvelle Dépense
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-red-500">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Libellé</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Caisse</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-white uppercase">Montant</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($depenses as $depense)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm">{{ $depense->date_depense->format('d/m/Y à H:i') }}</td>
                    <td class="px-4 py-3 text-sm font-medium">{{ $depense->libelle }}</td>
                    <td class="px-4 py-3 text-sm">{{ $depense->caisse->nom ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-right font-bold text-red-600">
                        -{{ number_format($depense->montant, 2) }} GNF
                    </td>
                    <td class="px-4 py-3 text-sm flex space-x-1">
                        <a href="{{ route('depenses.edit', $depense->id) }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">
                            Modifier
                        </a>
                        <form action="{{ route('depenses.destroy', $depense->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs"
                                onclick="return confirm('Voulez-vous vraiment supprimer cette dépense ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">Aucune dépense trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $depenses->links() }}
    </div>
</div>
@endsection
