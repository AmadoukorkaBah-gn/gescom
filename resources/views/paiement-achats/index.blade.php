@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Paiements Fournisseurs</h1>
        <a href="{{ route('paiement-achats.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nouveau Paiement
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-orange-500">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase">N°</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase">Fournisseur</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase">Achat #</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase">Montant</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase">Mode</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase">Caisse</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($paiements as $paiement)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 text-sm font-medium">{{ $paiement->achat->fournisseur->nom_fournisseur ?? '-' }}</td>
                    <td class="px-4 py-2 text-sm">#{{ $paiement->achat_id }}</td>
                    <td class="px-4 py-2 text-sm font-bold text-green-600">{{ number_format($paiement->montant_paye, 2) }} GNF</td>
                    <td class="px-4 py-2 text-sm">{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                    <td class="px-4 py-2 text-sm">{{ ucfirst($paiement->mode) }}</td>
                    <td class="px-4 py-2 text-sm">{{ $paiement->caisse->nom ?? '-' }}</td>
                    <td class="px-4 py-2 text-sm">
                        <div class="flex space-x-1">
                            <a href="{{ route('achats.show', $paiement->achat_id) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-2 py-1 rounded text-xs">
                                Voir Achat
                            </a>
                            <form action="{{ route('paiement-achats.destroy', $paiement) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce paiement ? La caisse sera remboursée.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                        Aucun paiement fournisseur enregistré.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4 px-4 pb-4">
            {{ $paiements->links() }}
        </div>
    </div>
</div>
@endsection
