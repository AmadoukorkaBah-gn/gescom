@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
	<h1 class="text-2xl font-bold text-gray-800 mb-6">Nouveau Paiement</h1>

	<form action="{{ route('paiement.store') }}" method="POST" class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6">
		@csrf


		@php
			$ownerId = Auth::user()->getOwnerId();
			$ventes = App\Models\Vente::with(['client', 'paiements'])
				->where('user_id', $ownerId)
				->whereIn('statut', ['en_cours', 'partiel'])
				->orderBy('date_vente', 'desc')
				->get();
			$selectedVente = null;
			if(isset($vente_id)) {
				$selectedVente = App\Models\Vente::with('paiements')->find($vente_id);
			}
		@endphp

		<div class="mb-4">
			<label for="vente_id" class="block text-sm font-medium text-gray-700">Vente concernée</label>
			<select name="vente_id" id="vente_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required onchange="updateVenteInfo()">
				<option value="">Sélectionner une vente</option>
				@foreach($ventes as $v)
					@php
						$totalPaye = $v->paiements->sum('montant_paye');
						$resteAPayer = $v->montant_total - $totalPaye;
					@endphp
					<option value="{{ $v->id }}" 
							data-total="{{ $v->montant_total }}"
							data-paye="{{ $totalPaye }}"
							data-reste="{{ $resteAPayer }}"
							{{ (isset($vente_id) && $vente_id == $v->id) ? 'selected' : '' }}>
						#{{ $v->id }} - {{ $v->client->nom_client ?? 'Client inconnu' }} ({{ $v->date_vente->format('d/m/Y') }}) - Reste: {{ number_format($resteAPayer, 2) }} GNF
					</option>
				@endforeach
			</select>
		</div>

		<div id="vente-info" class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded {{ $selectedVente ? '' : 'hidden' }}">
			@if($selectedVente)
				@php
					$totalPaye = $selectedVente->paiements->sum('montant_paye');
					$resteAPayer = $selectedVente->montant_total - $totalPaye;
				@endphp
				<div class="grid grid-cols-2 gap-2 text-sm">
					<div><strong>Montant total:</strong></div>
					<div>{{ number_format((float) $selectedVente->montant_total, 2) }} GNF</div>
					<div><strong>Déjà payé:</strong></div>
					<div class="text-green-600">{{ number_format($totalPaye, 2) }} GNF</div>
					<div><strong>Reste à payer:</strong></div>
					<div class="text-red-600 font-bold">{{ number_format($resteAPayer, 2) }} GNF</div>
				</div>
			@else
				<div class="grid grid-cols-2 gap-2 text-sm">
					<div><strong>Montant total:</strong></div>
					<div id="info-total">-</div>
					<div><strong>Déjà payé:</strong></div>
					<div class="text-green-600" id="info-paye">-</div>
					<div><strong>Reste à payer:</strong></div>
					<div class="text-red-600 font-bold" id="info-reste">-</div>
				</div>
			@endif
		</div>

		<div class="mb-4">
			<label for="montant_paye" class="block text-sm font-medium text-gray-700">Montant payé</label>
			<input type="number" step="0.01" min="0" name="montant_paye" id="montant_paye" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
		</div>

		<div class="mb-4">
			<label for="date_paiement" class="block text-sm font-medium text-gray-700">Date du paiement</label>
			<input type="date" name="date_paiement" id="date_paiement" value="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
		</div>

		<div class="mb-4">
			<label for="mode" class="block text-sm font-medium text-gray-700">Mode de paiement</label>
			<select name="mode" id="mode" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
				<option value="">Sélectionner un mode</option>
				<option value="espèces">Espèces</option>
				<option value="mobile_money">Mobile Money</option>
				<option value="chèque">Chèque</option>
				<option value="virement">Virement</option>
				<option value="autre">Autre</option>
			</select>
		</div>

		<div class="mb-4">
			<label for="caisse_id" class="block text-sm font-medium text-gray-700">Caisse de destination</label>
			<select name="caisse_id" id="caisse_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
				<option value="">Sélectionner une caisse</option>
				@foreach($caisses ?? App\Models\Caisse::orderBy('nom')->get() as $caisse)
					<option value="{{ $caisse->id }}">
						{{ $caisse->nom }} (Solde: {{ number_format($caisse->solde, 2) }} GNF)
					</option>
				@endforeach
			</select>
			<p class="text-sm text-gray-500 mt-1">Le montant payé sera crédité dans cette caisse.</p>
		</div>

		<div class="flex justify-between">
			<a href="{{ route('ventes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
				Annuler
			</a>
			<button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
				Enregistrer le paiement
			</button>
		</div>
	</form>
</div>

<script>
function updateVenteInfo() {
    const select = document.getElementById('vente_id');
    const option = select.options[select.selectedIndex];
    const infoDiv = document.getElementById('vente-info');
    
    if (option.value) {
        const total = parseFloat(option.dataset.total);
        const paye = parseFloat(option.dataset.paye);
        const reste = parseFloat(option.dataset.reste);
        
        document.getElementById('info-total').textContent = total.toLocaleString('fr-FR', {minimumFractionDigits: 2}) + ' GNF';
        document.getElementById('info-paye').textContent = paye.toLocaleString('fr-FR', {minimumFractionDigits: 2}) + ' GNF';
        document.getElementById('info-reste').textContent = reste.toLocaleString('fr-FR', {minimumFractionDigits: 2}) + ' GNF';
        
        // Mettre le reste à payer comme valeur par défaut
        document.getElementById('montant_paye').value = reste;
        
        infoDiv.classList.remove('hidden');
    } else {
        infoDiv.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('vente_id');
    if (select.value) {
        updateVenteInfo();
    }
});
</script>
@endsection
