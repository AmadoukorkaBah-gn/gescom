@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 sm:py-8">
    <div class="container mx-auto px-3 sm:px-4 lg:px-6">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 tracking-tight">
                    Liste des Dépenses
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Gestion et suivi des dépenses
                </p>
            </div>

            <a href="{{ route('depenses.create') }}"
               class="inline-flex items-center justify-center gap-2
                      bg-blue-600 hover:bg-blue-700
                      text-white font-semibold
                      px-4 py-2.5 rounded-lg
                      shadow-sm hover:shadow-md
                      transition duration-200">

                <i class="fas fa-plus"></i>
                <span>Nouvelle Dépense</span>
            </a>
        </div>


        {{-- =====================================================
             MESSAGES
        ====================================================== --}}
        @if(session('success'))
            <div class="mb-5 flex items-start gap-3
                        bg-green-50 border border-green-200
                        text-green-800
                        px-4 py-3 rounded-lg shadow-sm">

                <i class="fas fa-check-circle mt-0.5 text-green-600"></i>

                <span class="text-sm font-medium">
                    {{ session('success') }}
                </span>
            </div>
        @endif


        @if(session('error'))
            <div class="mb-5 flex items-start gap-3
                        bg-red-50 border border-red-200
                        text-red-800
                        px-4 py-3 rounded-lg shadow-sm">

                <i class="fas fa-exclamation-circle mt-0.5 text-red-600"></i>

                <span class="text-sm font-medium">
                    {{ session('error') }}
                </span>
            </div>
        @endif


        {{-- =====================================================
             TABLEAU
        ====================================================== --}}
        <div class="bg-white
                    border border-blue-100
                    rounded-xl
                    shadow-sm
                    overflow-hidden">

            {{-- Barre supérieure --}}
            <div class="px-4 sm:px-6 py-4
                        border-b border-blue-100
                        bg-gradient-to-r from-blue-50 to-white">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10
                                flex items-center justify-center
                                rounded-lg
                                bg-blue-100 text-blue-600">

                        <i class="fas fa-receipt"></i>
                    </div>

                    <div>
                        <h2 class="font-bold text-gray-800">
                            Historique des dépenses
                        </h2>

                        <p class="text-xs sm:text-sm text-gray-500">
                            Consultez et gérez vos dépenses
                        </p>
                    </div>

                </div>
            </div>


            {{-- Scroll horizontal sur mobile --}}
            <div class="overflow-x-auto">

                <table class="min-w-[750px] w-full">

                    {{-- =================================================
                         EN-TÊTE
                    ================================================== --}}
                    <thead class="bg-blue-600">

                        <tr>

                            <th class="px-4 py-3.5
                                       text-left
                                       text-xs font-bold
                                       text-white uppercase
                                       tracking-wider">
                                Date
                            </th>

                            <th class="px-4 py-3.5
                                       text-left
                                       text-xs font-bold
                                       text-white uppercase
                                       tracking-wider">
                                Libellé
                            </th>

                            <th class="px-4 py-3.5
                                       text-left
                                       text-xs font-bold
                                       text-white uppercase
                                       tracking-wider">
                                Caisse
                            </th>

                            <th class="px-4 py-3.5
                                       text-right
                                       text-xs font-bold
                                       text-white uppercase
                                       tracking-wider">
                                Montant
                            </th>

                            <th class="px-4 py-3.5
                                       text-center
                                       text-xs font-bold
                                       text-white uppercase
                                       tracking-wider">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    {{-- =================================================
                         CORPS
                    ================================================== --}}
                    <tbody class="divide-y divide-gray-100">

                        @forelse($depenses as $depense)

                        <tr class="hover:bg-blue-50/50 transition duration-150">

                            {{-- DATE --}}
                            <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">

                                <div class="flex items-center gap-2">

                                    <div class="w-8 h-8
                                                flex items-center justify-center
                                                rounded-lg
                                                bg-blue-50 text-blue-600">

                                        <i class="fas fa-calendar-alt text-xs"></i>

                                    </div>

                                    <span class="font-medium">
                                        {{ $depense->date_depense->format('d/m/Y à H:i') }}
                                    </span>

                                </div>

                            </td>


                            {{-- LIBELLÉ --}}
                            <td class="px-4 py-4 text-sm text-gray-800">

                                <span class="font-semibold">
                                    {{ $depense->libelle }}
                                </span>

                            </td>


                            {{-- CAISSE --}}
                            <td class="px-4 py-4 text-sm text-gray-700">

                                <span class="inline-flex items-center gap-2
                                             px-3 py-1.5
                                             rounded-lg
                                             bg-gray-50
                                             border border-gray-200">

                                    <i class="fas fa-wallet text-blue-600 text-xs"></i>

                                    <span>
                                        {{ $depense->caisse->nom ?? '-' }}
                                    </span>

                                </span>

                            </td>


                            {{-- MONTANT --}}
                            <td class="px-4 py-4 text-sm text-right whitespace-nowrap">

                                <span class="inline-flex items-center
                                             px-3 py-1.5
                                             rounded-lg
                                             bg-red-50
                                             border border-red-100
                                             font-bold text-red-600">

                                    -{{ number_format($depense->montant, 2) }} GNF

                                </span>

                            </td>


                            {{-- ACTIONS --}}
                            <td class="px-4 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- Modifier --}}
                                    <a href="{{ route('depenses.edit', $depense->id) }}"
                                       class="inline-flex items-center gap-1.5
                                              bg-yellow-500 hover:bg-yellow-600
                                              text-white
                                              px-3 py-2
                                              rounded-lg
                                              text-xs font-semibold
                                              shadow-sm
                                              transition duration-200">

                                        <i class="fas fa-edit"></i>
                                        <span>Modifier</span>

                                    </a>


                                    {{-- Supprimer --}}
                                    <form action="{{ route('depenses.destroy', $depense->id) }}"
                                          method="POST"
                                          class="inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5
                                                       bg-red-500 hover:bg-red-600
                                                       text-white
                                                       px-3 py-2
                                                       rounded-lg
                                                       text-xs font-semibold
                                                       shadow-sm
                                                       transition duration-200"
                                                onclick="return confirm('Voulez-vous vraiment supprimer cette dépense ?')">

                                            <i class="fas fa-trash"></i>
                                            <span>Supprimer</span>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="px-6 py-12 text-center">

                                <div class="flex flex-col items-center justify-center">

                                    <div class="w-16 h-16
                                                flex items-center justify-center
                                                rounded-full
                                                bg-blue-50
                                                text-blue-400
                                                mb-4">

                                        <i class="fas fa-receipt text-2xl"></i>

                                    </div>

                                    <h3 class="text-base font-semibold text-gray-700">
                                        Aucune dépense trouvée
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Aucune dépense n'a encore été enregistrée.
                                    </p>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =====================================================
                 PAGINATION
            ====================================================== --}}
            @if($depenses->hasPages())

                <div class="px-4 sm:px-6 py-4
                            border-t border-blue-100
                            bg-gray-50">

                    {{ $depenses->links() }}

                </div>

            @endif

        </div>

    </div>
</div>
@endsection