@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Réception de l'Achat #{{ $achat->id }}</h1>
        
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Récapitulatif de l'achat -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Récapitulatif</h2>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-gray-600">Fournisseur</p>
                    <p class="font-medium">{{ $achat->fournisseur->nom_fournisseur }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Date d'achat</p>
                    <p class="font-medium">{{ \Carbon\Carbon::parse($achat->date_achat)->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">N° Facture</p>
                    <p class="font-medium">{{ $achat->numero_facture ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Total à payer</p>
                    <p class="font-bold text-xl text-red-600">{{ number_format($achat->total, 2) }} GNF</p>
                </div>
            </div>

            <!-- Détails des produits -->
            <h3 class="font-semibold mb-2">Produits commandés</h3>
            <table class="min-w-full divide-y divide-gray-200 mb-4">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-bold uppercase">Produit</th>
                        <th class="px-3 py-2 text-center text-xs font-bold uppercase">Qté</th>
                        <th class="px-3 py-2 text-right text-xs font-bold uppercase">Prix Unit.</th>
                        <th class="px-3 py-2 text-right text-xs font-bold uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($achat->details as $detail)
                    <tr>
                        <td class="px-3 py-2 text-sm">{{ $detail->produit->nom_produit }}</td>
                        <td class="px-3 py-2 text-sm text-center">{{ $detail->quantite }}</td>
                        <td class="px-3 py-2 text-sm text-right">{{ number_format($detail->prix_unitaire, 2) }}</td>
                        <td class="px-3 py-2 text-sm text-right font-medium">{{ number_format($detail->quantite * $detail->prix_unitaire, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Formulaire de réception -->
        <form action="{{ route('achats.receive', $achat->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            
            <h2 class="text-lg font-semibold mb-4">Mode de paiement</h2>
            
            <!-- Type de paiement -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Comment souhaitez-vous payer cet achat ?</label>
                <div class="space-y-2">
                    <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="type_paiement" value="comptant" class="mr-3" {{ old('type_paiement', 'comptant') == 'comptant' ? 'checked' : '' }} onchange="togglePaiementFields()">
                        <div>
                            <span class="font-medium text-green-600">Paiement comptant</span>
                            <p class="text-sm text-gray-500">Payer la totalité maintenant ({{ number_format($achat->total, 2) }} GNF)</p>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="type_paiement" value="partiel" class="mr-3" {{ old('type_paiement') == 'partiel' ? 'checked' : '' }} onchange="togglePaiementFields()">
                        <div>
                            <span class="font-medium text-orange-600">Paiement partiel</span>
                            <p class="text-sm text-gray-500">Payer une partie maintenant, le reste plus tard</p>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="type_paiement" value="credit" class="mr-3" {{ old('type_paiement') == 'credit' ? 'checked' : '' }} onchange="togglePaiementFields()">
                        <div>
                            <span class="font-medium text-red-600">Achat à crédit</span>
                            <p class="text-sm text-gray-500">Recevoir le stock sans payer maintenant</p>
                        </div>
                    </label>
                </div>
                @error('type_paiement')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champs pour paiement comptant/partiel -->
            <div id="paiement-fields" class="space-y-4">
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Choisir la caisse</label>
                    <select name="caisse_id" id="caisse_id" class="form-select w-full border rounded px-3 py-2 @error('caisse_id') border-red-500 @enderror">
                        <option value="">-- Sélectionner une caisse --</option>
                        @foreach($caisses as $caisse)
                            <option value="{{ $caisse->id }}" data-solde="{{ $caisse->solde }}" {{ old('caisse_id') == $caisse->id ? 'selected' : '' }}>
                                {{ $caisse->nom }} - Solde: {{ number_format($caisse->solde, 2) }} GNF
                            </option>
                        @endforeach
                    </select>
                    @error('caisse_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Montant partiel -->
                <div id="montant-partiel" class="mb-4 hidden">
                    <label class="block text-gray-700 font-semibold mb-2">Montant à payer maintenant</label>
                    <input type="number" name="montant_paye" id="montant_paye" step="0.01" min="0" max="{{ $achat->total }}" 
                           class="form-input w-full border rounded px-3 py-2 @error('montant_paye') border-red-500 @enderror"
                           value="{{ old('montant_paye') }}" placeholder="0.00">
                    @error('montant_paye')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Maximum: {{ number_format($achat->total, 2) }} GNF</p>
                </div>
            </div>
            
            <div class="flex space-x-2 mt-6">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                    Confirmer la réception
                </button>
                <a href="{{ route('achats.show', $achat->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePaiementFields() {
    const type = document.querySelector('input[name="type_paiement"]:checked').value;
    const paiementFields = document.getElementById('paiement-fields');
    const montantPartiel = document.getElementById('montant-partiel');
    const caisseSelect = document.getElementById('caisse_id');
    
    if (type === 'credit') {
        paiementFields.classList.add('hidden');
        caisseSelect.removeAttribute('required');
    } else {
        paiementFields.classList.remove('hidden');
        caisseSelect.setAttribute('required', 'required');
        
        if (type === 'partiel') {
            montantPartiel.classList.remove('hidden');
        } else {
            montantPartiel.classList.add('hidden');
        }
    }
}

// Initialiser au chargement
document.addEventListener('DOMContentLoaded', togglePaiementFields);
</script>
@endsection
