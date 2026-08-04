@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Paiement Fournisseur</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('paiement-achats.store') }}" method="POST" class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6">
        @csrf

        <!-- Achat sélectionné ou liste -->
        <div class="mb-4">
            <label for="achat_id" class="block text-sm font-medium text-gray-700">Achat concerné</label>
            <select name="achat_id" id="achat_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required onchange="updateAchatInfo()">
                <option value="">Sélectionner un achat</option>
                @foreach($achats as $a)
                    <option value="{{ $a->id }}" 
                            data-total="{{ $a->total }}" 
                            data-paye="{{ $a->montant_paye }}"
                            data-reste="{{ $a->reste_a_payer }}"
                            {{ (isset($achat) && $achat->id == $a->id) ? 'selected' : '' }}>
                        #{{ $a->id }} - {{ $a->fournisseur->nom_fournisseur }} ({{ $a->date_achat->format('d/m/Y') }}) - Reste: {{ number_format($a->reste_a_payer, 2) }} GNF
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Informations sur l'achat -->
        <div id="achat-info" class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded {{ isset($achat) ? '' : 'hidden' }}">
            @if(isset($achat))
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div><strong>Total achat:</strong></div>
                    <div>{{ number_format($achat->total, 2) }} GNF</div>
                    <div><strong>Déjà payé:</strong></div>
                    <div class="text-green-600">{{ number_format($achat->montant_paye, 2) }} GNF</div>
                    <div><strong>Reste à payer:</strong></div>
                    <div class="text-red-600 font-bold" id="reste-a-payer">{{ number_format($achat->reste_a_payer, 2) }} GNF</div>
                </div>
            @else
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div><strong>Total achat:</strong></div>
                    <div id="info-total">-</div>
                    <div><strong>Déjà payé:</strong></div>
                    <div class="text-green-600" id="info-paye">-</div>
                    <div><strong>Reste à payer:</strong></div>
                    <div class="text-red-600 font-bold" id="info-reste">-</div>
                </div>
            @endif
        </div>

        <div class="mb-4">
            <label for="montant_paye" class="block text-sm font-medium text-gray-700">Montant à payer</label>
            <input type="number" step="0.01" min="0.01" name="montant_paye" id="montant_paye" 
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('montant_paye') border-red-500 @enderror" 
                   value="{{ old('montant_paye') }}" required>
            @error('montant_paye')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="date_paiement" class="block text-sm font-medium text-gray-700">Date du paiement</label>
            <input type="date" name="date_paiement" id="date_paiement" value="{{ date('Y-m-d') }}" 
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="mode" class="block text-sm font-medium text-gray-700">Mode de paiement</label>
            <select name="mode" id="mode" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="">Sélectionner un mode</option>
                <option value="especes">Espèces</option>
                <option value="mobile_money">Mobile Money</option>
                <option value="cheque">Chèque</option>
                <option value="virement">Virement</option>
                <option value="autre">Autre</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="caisse_id" class="block text-sm font-medium text-gray-700">Caisse source</label>
            <select name="caisse_id" id="caisse_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('caisse_id') border-red-500 @enderror" required>
                <option value="">Sélectionner une caisse</option>
                @foreach($caisses as $caisse)
                    <option value="{{ $caisse->id }}">
                        {{ $caisse->nom }} (Solde: {{ number_format($caisse->solde, 2) }} GNF)
                    </option>
                @endforeach
            </select>
            @error('caisse_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Le montant sera débité de cette caisse.</p>
        </div>

        <div class="mb-4">
            <label for="note" class="block text-sm font-medium text-gray-700">Note (optionnel)</label>
            <textarea name="note" id="note" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('note') }}</textarea>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('achats.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Annuler
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Enregistrer le paiement
            </button>
        </div>
    </form>
</div>

<script>
function updateAchatInfo() {
    const select = document.getElementById('achat_id');
    const option = select.options[select.selectedIndex];
    const infoDiv = document.getElementById('achat-info');
    
    if (option.value) {
        const total = parseFloat(option.dataset.total);
        const paye = parseFloat(option.dataset.paye);
        const reste = parseFloat(option.dataset.reste);
        
        document.getElementById('info-total').textContent = total.toLocaleString('fr-FR', {minimumFractionDigits: 2}) + ' GNF';
        document.getElementById('info-paye').textContent = paye.toLocaleString('fr-FR', {minimumFractionDigits: 2}) + ' GNF';
        document.getElementById('info-reste').textContent = reste.toLocaleString('fr-FR', {minimumFractionDigits: 2}) + ' GNF';
        
        // Mettre le reste à payer comme valeur par défaut
        document.getElementById('montant_paye').max = reste;
        document.getElementById('montant_paye').value = reste;
        
        infoDiv.classList.remove('hidden');
    } else {
        infoDiv.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('achat_id');
    if (select.value) {
        updateAchatInfo();
    }
});
</script>
@endsection
