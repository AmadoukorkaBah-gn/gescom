@extends('layouts.app')

@section('content')

<div class="w-full px-3 sm:px-5 lg:px-8 py-5 sm:py-8">

    {{-- En-tête --}}
    <div class="max-w-3xl mx-auto mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">
                    Nouveau Paiement
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Enregistrer un paiement pour une vente en cours
                </p>
            </div>

        </div>
    </div>


    {{-- Formulaire --}}
    <form
        action="{{ route('paiement.store') }}"
        method="POST"
        class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden"
    >

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


        {{-- En-tête du formulaire --}}
        <div class="px-4 sm:px-6 lg:px-8 py-5 border-b border-gray-100 bg-gray-50/70">

            <h2 class="text-lg sm:text-xl font-bold text-gray-800">
                Informations du paiement
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Sélectionnez la vente et renseignez les informations du règlement.
            </p>

        </div>


        <div class="p-4 sm:p-6 lg:p-8">


            {{-- Vente concernée --}}
            <div class="mb-5">

                <label
                    for="vente_id"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Vente concernée
                </label>

                <select
                    name="vente_id"
                    id="vente_id"
                    class="w-full border border-gray-300 rounded-xl px-3 sm:px-4 py-3 text-sm sm:text-base bg-white
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           transition"
                    required
                    onchange="updateVenteInfo()"
                >

                    <option value="">
                        Sélectionner une vente
                    </option>

                    @foreach($ventes as $v)

                        @php
                            $totalPaye = $v->paiements->sum('montant_paye');
                            $resteAPayer = $v->montant_total - $totalPaye;
                        @endphp

                        <option
                            value="{{ $v->id }}"
                            data-total="{{ $v->montant_total }}"
                            data-paye="{{ $totalPaye }}"
                            data-reste="{{ $resteAPayer }}"
                            {{ (isset($vente_id) && $vente_id == $v->id) ? 'selected' : '' }}
                        >

                            #{{ $v->id }}
                            -
                            {{ $v->client->nom_client ?? 'Client inconnu' }}
                            -
                            {{ $v->date_vente->format('d/m/Y') }}
                            -
                            Reste:
                            {{ number_format($resteAPayer, 2) }} GNF

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Informations vente --}}
            <div
                id="vente-info"
                class="mb-6 p-4 sm:p-5 bg-blue-50 border border-blue-200 rounded-xl
                       {{ $selectedVente ? '' : 'hidden' }}"
            >

                <div class="flex items-center gap-2 mb-4">

                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-blue-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 14l6-6m-5-5h5a2 2 0 012 2v14a2 2 0 01-2 2H9a2 2 0 01-2-2V5a2 2 0 012-2z"
                            />
                        </svg>

                    </div>

                    <h3 class="font-bold text-gray-800">
                        Situation de la vente
                    </h3>

                </div>


                @if($selectedVente)

                    @php
                        $totalPaye = $selectedVente->paiements->sum('montant_paye');
                        $resteAPayer = $selectedVente->montant_total - $totalPaye;
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">

                        <div class="bg-white rounded-xl p-4 border border-blue-100">

                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                Montant total
                            </p>

                            <p class="mt-1 text-base sm:text-lg font-bold text-gray-800">
                                {{ number_format((float) $selectedVente->montant_total, 2) }}
                                <span class="text-xs font-medium">GNF</span>
                            </p>

                        </div>


                        <div class="bg-white rounded-xl p-4 border border-green-100">

                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                Déjà payé
                            </p>

                            <p class="mt-1 text-base sm:text-lg font-bold text-green-600">
                                {{ number_format($totalPaye, 2) }}
                                <span class="text-xs font-medium">GNF</span>
                            </p>

                        </div>


                        <div class="bg-white rounded-xl p-4 border border-red-100">

                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                Reste à payer
                            </p>

                            <p class="mt-1 text-base sm:text-lg font-bold text-red-600">
                                {{ number_format($resteAPayer, 2) }}
                                <span class="text-xs font-medium">GNF</span>
                            </p>

                        </div>

                    </div>

                @else

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">

                        <div class="bg-white rounded-xl p-4 border border-blue-100">

                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                Montant total
                            </p>

                            <p
                                id="info-total"
                                class="mt-1 text-base sm:text-lg font-bold text-gray-800"
                            >
                                -
                            </p>

                        </div>


                        <div class="bg-white rounded-xl p-4 border border-green-100">

                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                Déjà payé
                            </p>

                            <p
                                id="info-paye"
                                class="mt-1 text-base sm:text-lg font-bold text-green-600"
                            >
                                -
                            </p>

                        </div>


                        <div class="bg-white rounded-xl p-4 border border-red-100">

                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                Reste à payer
                            </p>

                            <p
                                id="info-reste"
                                class="mt-1 text-base sm:text-lg font-bold text-red-600"
                            >
                                -
                            </p>

                        </div>

                    </div>

                @endif

            </div>


            {{-- Montant payé --}}
            <div class="mb-5">

                <label
                    for="montant_paye"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Montant payé
                </label>

                <div class="relative">

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        name="montant_paye"
                        id="montant_paye"
                        class="w-full border border-gray-300 rounded-xl px-3 sm:px-4 py-3 pr-16 text-sm sm:text-base
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition"
                        required
                    >

                    <span
                        class="absolute right-3 top-1/2 -translate-y-1/2
                               text-xs sm:text-sm font-semibold text-gray-500"
                    >
                        GNF
                    </span>

                </div>

            </div>


            {{-- Date --}}
            <div class="mb-5">

                <label
                    for="date_paiement"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Date du paiement
                </label>

                <input
                    type="date"
                    name="date_paiement"
                    id="date_paiement"
                    value="{{ date('Y-m-d') }}"
                    class="w-full border border-gray-300 rounded-xl px-3 sm:px-4 py-3 text-sm sm:text-base
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           transition"
                    required
                >

            </div>


            {{-- Mode paiement --}}
            <div class="mb-5">

                <label
                    for="mode"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Mode de paiement
                </label>

                <select
                    name="mode"
                    id="mode"
                    class="w-full border border-gray-300 rounded-xl px-3 sm:px-4 py-3 text-sm sm:text-base bg-white
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           transition"
                    required
                >

                    <option value="">
                        Sélectionner un mode
                    </option>

                    <option value="espèces">
                        Espèces
                    </option>

                    <option value="mobile_money">
                        Mobile Money
                    </option>

                    <option value="chèque">
                        Chèque
                    </option>

                    <option value="virement">
                        Virement
                    </option>

                    <option value="autre">
                        Autre
                    </option>

                </select>

            </div>


            {{-- Caisse --}}
            <div class="mb-6">

                <label
                    for="caisse_id"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Caisse de destination
                </label>

                <select
                    name="caisse_id"
                    id="caisse_id"
                    class="w-full border border-gray-300 rounded-xl px-3 sm:px-4 py-3 text-sm sm:text-base bg-white
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           transition"
                    required
                >

                    <option value="">
                        Sélectionner une caisse
                    </option>

                    @foreach($caisses ?? App\Models\Caisse::orderBy('nom')->get() as $caisse)

                        <option value="{{ $caisse->id }}">

                            {{ $caisse->nom }}

                            (Solde:
                            {{ number_format($caisse->solde, 2) }}
                            GNF)

                        </option>

                    @endforeach

                </select>

                <p class="text-xs sm:text-sm text-gray-500 mt-2">
                    Le montant payé sera crédité dans cette caisse.
                </p>

            </div>


            {{-- Boutons --}}
            <div
                class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3
                       pt-5 border-t border-gray-100"
            >

                <a
                    href="{{ route('ventes.index') }}"
                    class="w-full sm:w-auto inline-flex justify-center items-center
                           bg-gray-500 hover:bg-gray-600
                           text-white font-semibold
                           py-3 px-5 rounded-xl
                           transition duration-200"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    class="w-full sm:w-auto inline-flex justify-center items-center
                           bg-blue-600 hover:bg-blue-700
                           text-white font-semibold
                           py-3 px-5 rounded-xl
                           shadow-sm hover:shadow
                           transition duration-200"
                >
                    Enregistrer le paiement
                </button>

            </div>

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

        document.getElementById('info-total').textContent =
            total.toLocaleString('fr-FR', {
                minimumFractionDigits: 2
            }) + ' GNF';

        document.getElementById('info-paye').textContent =
            paye.toLocaleString('fr-FR', {
                minimumFractionDigits: 2
            }) + ' GNF';

        document.getElementById('info-reste').textContent =
            reste.toLocaleString('fr-FR', {
                minimumFractionDigits: 2
            }) + ' GNF';

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