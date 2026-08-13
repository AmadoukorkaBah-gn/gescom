@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50 py-6 sm:py-8">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center">
                        <span class="text-xl">↩️</span>
                    </div>

                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                            Liste des retours
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            Consultez et gérez les retours de marchandises.
                        </p>
                    </div>
                </div>
            </div>


            {{-- Bouton ajouter --}}

            <a
                href="{{ route('retours.create') }}"
                class="inline-flex items-center justify-center gap-2
                       px-4 py-2.5
                       rounded-lg
                       bg-indigo-600
                       text-white
                       text-sm font-semibold
                       shadow-sm
                       hover:bg-indigo-700
                       transition
                       w-full sm:w-auto"
            >
                <span class="text-lg leading-none">+</span>
                Ajouter un retour
            </a>

        </div>


        {{-- =====================================================
             TABLEAU
        ====================================================== --}}

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

            {{-- Barre supérieure --}}

            <div class="px-5 py-4 border-b border-slate-200 bg-white">

                <div class="flex items-center justify-between gap-3">

                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-800">
                            Retours enregistrés
                        </h2>

                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Historique des retours effectués.
                        </p>
                    </div>

                    <div class="hidden sm:flex items-center gap-2
                                px-3 py-1.5
                                rounded-lg
                                bg-slate-100
                                text-xs font-semibold
                                text-slate-600">

                        <span>📦</span>
                        Retours
                    </div>

                </div>

            </div>


            {{-- =================================================
                 VERSION DESKTOP
            ================================================== --}}

            <div class="hidden md:block overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-5 py-3 text-left text-xs font-bold
                                       uppercase tracking-wider text-slate-500">
                                ID
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-bold
                                       uppercase tracking-wider text-slate-500">
                                Produit
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-bold
                                       uppercase tracking-wider text-slate-500">
                                Vente
                            </th>

                            <th class="px-5 py-3 text-center text-xs font-bold
                                       uppercase tracking-wider text-slate-500">
                                Quantité
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-bold
                                       uppercase tracking-wider text-slate-500">
                                Raison
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-bold
                                       uppercase tracking-wider text-slate-500">
                                Date
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-bold
                                       uppercase tracking-wider text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($retours as $retour)

                            <tr class="hover:bg-slate-50 transition">

                                {{-- ID --}}

                                <td class="px-5 py-4">

                                    <span class="inline-flex items-center
                                                 px-2.5 py-1
                                                 rounded-md
                                                 bg-slate-100
                                                 text-slate-700
                                                 text-xs font-bold">
                                        #{{ $retour->id }}
                                    </span>

                                </td>


                                {{-- Produit --}}

                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="w-9 h-9 rounded-lg
                                                    bg-blue-50
                                                    flex items-center justify-center
                                                    flex-shrink-0">

                                            <span>📦</span>

                                        </div>

                                        <div class="min-w-0">

                                            <p class="font-semibold text-slate-800 truncate">
                                                {{ $retour->produit->nom_produit }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Vente --}}

                                <td class="px-5 py-4">

                                    <span class="inline-flex items-center
                                                 px-2.5 py-1
                                                 rounded-lg
                                                 bg-indigo-50
                                                 text-indigo-700
                                                 text-sm font-semibold">

                                        Vente #{{ $retour->vente->id }}

                                    </span>

                                </td>


                                {{-- Quantité --}}

                                <td class="px-5 py-4 text-center">

                                    <span class="inline-flex items-center justify-center
                                                 min-w-10
                                                 px-3 py-1.5
                                                 rounded-lg
                                                 bg-amber-50
                                                 text-amber-700
                                                 text-sm font-bold">

                                        {{ $retour->quantite }}

                                    </span>

                                </td>


                                {{-- Raison --}}

                                <td class="px-5 py-4">

                                    <span class="text-sm text-slate-600">
                                        {{ $retour->raison }}
                                    </span>

                                </td>


                                {{-- Date --}}

                                <td class="px-5 py-4">

                                    <span class="text-sm text-slate-600 whitespace-nowrap">
                                        {{ $retour->date_retour }}
                                    </span>

                                </td>


                                {{-- Actions --}}

                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-end gap-2">

                                        <a
                                            href="{{ route('retours.edit', $retour->id) }}"
                                            class="inline-flex items-center gap-1.5
                                                   px-3 py-1.5
                                                   rounded-lg
                                                   bg-amber-50
                                                   text-amber-700
                                                   text-xs font-semibold
                                                   hover:bg-amber-100
                                                   transition"
                                        >
                                            ✏️
                                            Modifier
                                        </a>


                                        <form
                                            action="{{ route('retours.destroy', $retour->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Supprimer ce retour ?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5
                                                       px-3 py-1.5
                                                       rounded-lg
                                                       bg-red-50
                                                       text-red-600
                                                       text-xs font-semibold
                                                       hover:bg-red-100
                                                       transition"
                                            >
                                                🗑️
                                                Supprimer
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-6 py-14 text-center">

                                    <div class="flex flex-col items-center">

                                        <div class="w-16 h-16 rounded-full
                                                    bg-slate-100
                                                    flex items-center justify-center
                                                    text-3xl mb-4">

                                            ↩️

                                        </div>

                                        <p class="font-semibold text-slate-700">
                                            Aucun retour enregistré
                                        </p>

                                        <p class="text-sm text-slate-500 mt-1">
                                            Les retours de marchandises apparaîtront ici.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                 VERSION MOBILE
            ================================================== --}}

            <div class="md:hidden divide-y divide-slate-100">

                @forelse($retours as $retour)

                    <div class="p-4">

                        {{-- En-tête carte --}}

                        <div class="flex items-start justify-between gap-3">

                            <div class="flex items-center gap-3 min-w-0">

                                <div class="w-10 h-10 rounded-lg
                                            bg-blue-50
                                            flex items-center justify-center
                                            flex-shrink-0">

                                    <span class="text-lg">📦</span>

                                </div>

                                <div class="min-w-0">

                                    <h3 class="font-bold text-slate-800 truncate">

                                        {{ $retour->produit->nom_produit }}

                                    </h3>

                                    <p class="text-xs text-slate-500 mt-1">

                                        Retour #{{ $retour->id }}

                                    </p>

                                </div>

                            </div>


                            <span class="flex-shrink-0
                                         px-2.5 py-1
                                         rounded-lg
                                         bg-amber-50
                                         text-amber-700
                                         text-xs font-bold">

                                Qté : {{ $retour->quantite }}

                            </span>

                        </div>


                        {{-- Informations --}}

                        <div class="grid grid-cols-2 gap-3 mt-4">

                            <div class="rounded-lg bg-slate-50 p-3">

                                <p class="text-xs text-slate-500">
                                    Vente
                                </p>

                                <p class="mt-1 text-sm font-bold text-indigo-700">

                                    #{{ $retour->vente->id }}

                                </p>

                            </div>


                            <div class="rounded-lg bg-slate-50 p-3">

                                <p class="text-xs text-slate-500">
                                    Date
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-700">

                                    {{ $retour->date_retour }}

                                </p>

                            </div>

                        </div>


                        {{-- Raison --}}

                        <div class="mt-3 rounded-lg border border-slate-200 p-3">

                            <p class="text-xs text-slate-500 mb-1">
                                Raison du retour
                            </p>

                            <p class="text-sm font-medium text-slate-700">

                                {{ $retour->raison }}

                            </p>

                        </div>


                        {{-- Actions --}}

                        <div class="grid grid-cols-2 gap-2 mt-4">

                            <a
                                href="{{ route('retours.edit', $retour->id) }}"
                                class="inline-flex items-center justify-center gap-2
                                       px-3 py-2.5
                                       rounded-lg
                                       bg-amber-50
                                       text-amber-700
                                       text-sm font-semibold
                                       hover:bg-amber-100
                                       transition"
                            >
                                ✏️ Modifier
                            </a>


                            <form
                                action="{{ route('retours.destroy', $retour->id) }}"
                                method="POST"
                                onsubmit="return confirm('Supprimer ce retour ?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2
                                           px-3 py-2.5
                                           rounded-lg
                                           bg-red-50
                                           text-red-600
                                           text-sm font-semibold
                                           hover:bg-red-100
                                           transition"
                                >
                                    🗑️ Supprimer
                                </button>

                            </form>

                        </div>

                    </div>

                @empty

                    <div class="p-10 text-center">

                        <div class="w-16 h-16 rounded-full
                                    bg-slate-100
                                    flex items-center justify-center
                                    text-3xl mx-auto mb-4">

                            ↩️

                        </div>

                        <p class="font-semibold text-slate-700">
                            Aucun retour enregistré
                        </p>

                        <p class="text-sm text-slate-500 mt-1">
                            Les retours apparaîtront ici.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection