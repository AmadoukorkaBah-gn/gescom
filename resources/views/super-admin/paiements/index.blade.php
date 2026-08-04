@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Historique des Paiements d'Abonnements</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Admin</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Type</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-600 uppercase">Montant</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Date paiement</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Mode</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Période</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($paiements as $paiement)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium">{{ $paiement->user->name }}</td>
                    <td class="px-4 py-3 text-sm">
                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">
                            {{ ucfirst($paiement->abonnement_type) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm text-right font-bold text-green-600">
                        {{ number_format($paiement->montant, 0, ',', ' ') }} GNF
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-sm">{{ ucfirst($paiement->mode) }}</td>
                    <td class="px-4 py-3 text-sm text-xs text-gray-500">
                        {{ $paiement->date_debut->format('d/m/Y') }} - {{ $paiement->date_fin->format('d/m/Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        Aucun paiement enregistré
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $paiements->links() }}
        </div>
    </div>
</div>
@endsection
