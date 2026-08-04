@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestion des Abonnements</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Admin</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Type</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Date début</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Date fin</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase">Statut</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($user->abonnement_type)
                            <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">
                                {{ ucfirst($user->abonnement_type) }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ $user->date_debut_abonnement ? $user->date_debut_abonnement->format('d/m/Y') : '-' }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ $user->date_fin_abonnement ? $user->date_fin_abonnement->format('d/m/Y') : '-' }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @if($user->statut_abonnement == 'actif') bg-green-100 text-green-800
                            @elseif($user->statut_abonnement == 'expire') bg-orange-100 text-orange-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($user->statut_abonnement) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button onclick="showAbonnementModal({{ $user->id }}, '{{ $user->name }}')" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">
                            🔄 Renouveler
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        Aucun utilisateur trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Modal pour renouveler abonnement -->
<div id="abonnementModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Renouveler l'abonnement de <span id="userName"></span></h3>
            <form id="abonnementForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Type d'abonnement</label>
                    <select name="abonnement_type" class="form-select w-full border rounded px-3 py-2" required>
                        <option value="">Sélectionner un type</option>
                        <option value="mensuel">Mensuel (50,000 GNF)</option>
                        <option value="trimestriel">Trimestriel (140,000 GNF)</option>
                        <option value="annuel">Annuel (500,000 GNF)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Mode de paiement</label>
                    <select name="mode" class="form-select w-full border rounded px-3 py-2">
                        <option value="especes">Espèces</option>
                        <option value="mobile_money">Mobile Money</option>
                        <option value="cheque">Chèque</option>
                        <option value="virement">Virement</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Note (optionnel)</label>
                    <textarea name="note" rows="2" class="form-input w-full border rounded px-3 py-2"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeAbonnementModal()" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Annuler
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Activer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showAbonnementModal(userId, userName) {
    document.getElementById('userName').textContent = userName;
    document.getElementById('abonnementForm').action = `/super-admin/users/${userId}/abonnement`;
    document.getElementById('abonnementModal').classList.remove('hidden');
}

function closeAbonnementModal() {
    document.getElementById('abonnementModal').classList.add('hidden');
}
</script>
@endsection
