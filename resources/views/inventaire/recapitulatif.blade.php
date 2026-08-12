@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50">


<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>

            <div class="flex items-center gap-2 mb-2">

                <a
                    href="{{ route('inventaire.index') }}"
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium"
                >
                    ← Inventaire
                </a>

            </div>

            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                📊 Récapitulatif de l'inventaire
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Vérifiez les écarts avant de clôturer l'inventaire.
            </p>

        </div>

        <a
            href="{{ route('inventaire.index') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-700 text-white text-sm font-semibold hover:bg-slate-800 transition"
        >
            ✏️ Modifier le comptage
        </a>

    </div>


    {{-- =====================================================
         MESSAGE
    ====================================================== --}}

    @if(session('success'))

        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">

            <div class="flex items-center gap-2">

                <span>✅</span>

                <span class="text-sm font-medium">
                    {{ session('success') }}
                </span>

            </div>

        </div>

    @endif


    {{-- =====================================================
         CARTES STATISTIQUES
    ====================================================== --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">


        {{-- GAIN --}}

        <div class="bg-white rounded-2xl border border-green-200 shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Gain d'inventaire
                    </p>

                    <p class="mt-2 text-2xl font-bold text-green-600">

                        {{ number_format($totalGain, 0, ',', ' ') }}

                        <span class="text-sm font-medium">
                            GNF
                        </span>

                    </p>

                </div>

                <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-2xl">
                    📈
                </div>

            </div>

            <p class="mt-3 text-xs text-slate-500">
                Valeur des quantités trouvées en plus.
            </p>

        </div>


        {{-- PERTE --}}

        <div class="bg-white rounded-2xl border border-red-200 shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Perte d'inventaire
                    </p>

                    <p class="mt-2 text-2xl font-bold text-red-600">

                        {{ number_format($totalPerte, 0, ',', ' ') }}

                        <span class="text-sm font-medium">
                            GNF
                        </span>

                    </p>

                </div>

                <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-2xl">
                    📉
                </div>

            </div>

            <p class="mt-3 text-xs text-slate-500">
                Valeur des quantités manquantes.
            </p>

        </div>


        {{-- ÉCART NET --}}

        <div class="bg-white rounded-2xl border border-blue-200 shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Écart net
                    </p>

                    <p
                        class="
                            mt-2
                            text-2xl
                            font-bold
                            {{ $ecartGlobal > 0
                                ? 'text-green-600'
                                : ($ecartGlobal < 0
                                    ? 'text-red-600'
                                    : 'text-slate-700')
                            }}
                        "
                    >

                        {{ number_format(abs($ecartGlobal), 0, ',', ' ') }}

                        <span class="text-sm font-medium">
                            GNF
                        </span>

                    </p>

                </div>

                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-2xl">
                    ⚖️
                </div>

            </div>


            <p class="mt-3 text-xs text-slate-500">

                @if($ecartGlobal > 0)

                    Situation globale : <strong class="text-green-600">gain</strong>.

                @elseif($ecartGlobal < 0)

                    Situation globale : <strong class="text-red-600">perte</strong>.

                @else

                    Aucun écart financier.

                @endif

            </p>

        </div>

    </div>


    {{-- =====================================================
         AVERTISSEMENT
    ====================================================== --}}

    @if($inventaires->count())

        <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 p-4">

            <div class="flex items-start gap-3">

                <div class="text-xl">
                    ⚠️
                </div>

                <div>

                    <h3 class="font-bold text-amber-900">
                        Attention avant clôture
                    </h3>

                    <p class="mt-1 text-sm text-amber-800">

                        Une fois l'inventaire clôturé, cette session ne sera plus
                        considérée comme un inventaire en cours.

                        Vérifiez attentivement les quantités comptées et les écarts.

                    </p>

                </div>

            </div>

        </div>

    @endif


    {{-- =====================================================
         TABLEAU DES ÉCARTS
    ====================================================== --}}

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-slate-200">

            <div class="flex items-center justify-between gap-3">

                <div>

                    <h2 class="font-bold text-slate-800">
                        Détail des écarts
                    </h2>

                    <p class="text-xs text-slate-500 mt-1">
                        {{ $inventaires->count() }} produit(s) dans cet inventaire.
                    </p>

                </div>

            </div>

        </div>


        {{-- =================================================
             MOBILE
        ================================================== --}}

        <div class="md:hidden divide-y divide-slate-100">

            @forelse($inventaires as $inventaire)

                <div class="p-4">

                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">

                            <h3 class="font-bold text-slate-800 truncate">
                                {{ $inventaire->nom_produit }}
                            </h3>

                            <p class="text-xs text-slate-500 mt-1">
                                Prix d'achat :
                                {{ number_format($inventaire->prix_produit, 0, ',', ' ') }}
                                GNF
                            </p>

                        </div>


                        @if($inventaire->ecart > 0)

                            <span class="flex-shrink-0 px-2.5 py-1 rounded-lg bg-green-100 text-green-700 text-xs font-bold">
                                Gain
                            </span>

                        @elseif($inventaire->ecart < 0)

                            <span class="flex-shrink-0 px-2.5 py-1 rounded-lg bg-red-100 text-red-700 text-xs font-bold">
                                Perte
                            </span>

                        @else

                            <span class="flex-shrink-0 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">
                                Conforme
                            </span>

                        @endif

                    </div>


                    <div class="grid grid-cols-3 gap-2 mt-4">

                        <div class="rounded-xl bg-slate-50 p-3 text-center">

                            <p class="text-[11px] text-slate-500">
                                Théorique
                            </p>

                            <p class="font-bold text-slate-800 mt-1">
                                {{ number_format($inventaire->stock_theorique, 0, ',', ' ') }}
                            </p>

                        </div>


                        <div class="rounded-xl bg-blue-50 p-3 text-center">

                            <p class="text-[11px] text-blue-600">
                                Réel
                            </p>

                            <p class="font-bold text-blue-700 mt-1">
                                {{ number_format($inventaire->stock_reel, 0, ',', ' ') }}
                            </p>

                        </div>


                        <div
                            class="
                                rounded-xl
                                p-3
                                text-center
                                {{ $inventaire->ecart > 0
                                    ? 'bg-green-50'
                                    : ($inventaire->ecart < 0
                                        ? 'bg-red-50'
                                        : 'bg-slate-50')
                                }}
                            "
                        >

                            <p class="text-[11px] text-slate-500">
                                Écart
                            </p>

                            <p
                                class="
                                    font-bold
                                    mt-1
                                    {{ $inventaire->ecart > 0
                                        ? 'text-green-700'
                                        : ($inventaire->ecart < 0
                                            ? 'text-red-700'
                                            : 'text-slate-700')
                                    }}
                                "
                            >

                                {{ $inventaire->ecart > 0 ? '+' : '' }}{{ number_format($inventaire->ecart, 2, ',', ' ') }}

                            </p>

                        </div>

                    </div>


                    <div class="mt-3 text-right">

                        <span class="text-sm font-semibold
                            {{ $inventaire->valeur_ecart > 0
                                ? 'text-green-600'
                                : ($inventaire->valeur_ecart < 0
                                    ? 'text-red-600'
                                    : 'text-slate-500')
                            }}"
                        >

                            {{ $inventaire->valeur_ecart > 0 ? '+' : '' }}

                            {{ number_format($inventaire->valeur_ecart, 0, ',', ' ') }}

                            GNF

                        </span>

                    </div>

                </div>

            @empty

                <div class="p-10 text-center">

                    <div class="text-4xl mb-3">
                        📦
                    </div>

                    <p class="font-semibold text-slate-700">
                        Aucun inventaire en cours
                    </p>

                    <p class="text-sm text-slate-500 mt-1">
                        Retournez à la page d'inventaire pour effectuer un comptage.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- =================================================
             DESKTOP
        ================================================== --}}

        <div class="hidden md:block overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Produit
                        </th>

                        <th class="px-5 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Théorique
                        </th>

                        <th class="px-5 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Réel
                        </th>

                        <th class="px-5 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Écart
                        </th>

                        <th class="px-5 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Valeur
                        </th>

                        <th class="px-5 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Situation
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($inventaires as $inventaire)

                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-5 py-4">

                                <div class="font-semibold text-slate-800">
                                    {{ $inventaire->nom_produit }}
                                </div>

                                <div class="text-xs text-slate-400 mt-1">

                                    Prix achat :
                                    {{ number_format($inventaire->prix_produit, 0, ',', ' ') }}
                                    GNF

                                </div>

                            </td>


                            <td class="px-5 py-4 text-center font-semibold text-slate-700">

                                {{ number_format($inventaire->stock_theorique, 0, ',', ' ') }}

                            </td>


                            <td class="px-5 py-4 text-center font-semibold text-blue-700">

                                {{ number_format($inventaire->stock_reel, 0, ',', ' ') }}

                            </td>


                            <td class="px-5 py-4 text-center">

                                <span
                                    class="
                                        inline-flex
                                        px-3
                                        py-1.5
                                        rounded-lg
                                        text-sm
                                        font-bold

                                        {{ $inventaire->ecart > 0
                                            ? 'bg-green-100 text-green-700'
                                            : ($inventaire->ecart < 0
                                                ? 'bg-red-100 text-red-700'
                                                : 'bg-slate-100 text-slate-600')
                                        }}
                                    "
                                >

                                    {{ $inventaire->ecart > 0 ? '+' : '' }}

                                    {{ number_format($inventaire->ecart, 2, ',', ' ') }}

                                </span>

                            </td>


                            <td class="px-5 py-4 text-right">

                                <span
                                    class="
                                        font-bold
                                        {{ $inventaire->valeur_ecart > 0
                                            ? 'text-green-600'
                                            : ($inventaire->valeur_ecart < 0
                                                ? 'text-red-600'
                                                : 'text-slate-500')
                                        }}
                                    "
                                >

                                    {{ $inventaire->valeur_ecart > 0 ? '+' : '' }}

                                    {{ number_format($inventaire->valeur_ecart, 0, ',', ' ') }}

                                    GNF

                                </span>

                            </td>


                            <td class="px-5 py-4 text-center">

                                @if($inventaire->ecart > 0)

                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-green-100 text-green-700 text-xs font-bold">
                                        📈 Gain
                                    </span>

                                @elseif($inventaire->ecart < 0)

                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-red-100 text-red-700 text-xs font-bold">
                                        📉 Perte
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">
                                        ✓ Conforme
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="px-5 py-12 text-center">

                                <div class="text-4xl mb-3">
                                    📦
                                </div>

                                <p class="font-semibold text-slate-700">
                                    Aucun inventaire en cours
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
         CLÔTURE
    ====================================================== --}}

    @if($inventaires->count())

        <div class="mt-6 bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                <div>

                    <h2 class="font-bold text-slate-800">
                        🔒 Clôturer l'inventaire
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Vérifiez les résultats ci-dessus avant de confirmer.
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route('inventaire.cloturer') }}"
                    onsubmit="return confirm('Êtes-vous sûr de vouloir clôturer cet inventaire ? Cette opération enregistrera définitivement cette session.');"
                >

                    @csrf

                    <button
                        type="submit"
                        class="w-full lg:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 active:scale-[0.98] transition"
                    >
                        🔒 Clôturer l'inventaire
                    </button>

                </form>

            </div>

        </div>

    @endif

</div>


</div>

@endsection
