@extends('layouts.app')

@section('content')

<div class="w-full max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6 lg:py-8">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 tracking-tight">
                Liste des Fournisseurs
            </h1>

            <p class="mt-1 text-sm sm:text-base text-gray-500">
                Gestion de vos fournisseurs
            </p>
        </div>

        <a href="{{ route('fournisseurs.create') }}"
           class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                  bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                  text-white font-semibold
                  px-4 py-2.5 rounded-xl shadow-sm
                  transition duration-200">

            <i class="fas fa-plus"></i>
            <span>Ajouter un Fournisseur</span>
        </a>

    </div>


    {{-- =========================================================
         MESSAGE DE SUCCÈS
    ========================================================== --}}
    @if(session('success'))

        <div class="mb-5 flex items-start gap-3
                    bg-green-50 border border-green-200
                    text-green-800
                    px-4 py-3 rounded-xl shadow-sm">

            <i class="fas fa-check-circle text-green-600 mt-0.5"></i>

            <p class="text-sm sm:text-base font-medium">
                {{ session('success') }}
            </p>

        </div>

    @endif


    {{-- =========================================================
         TABLEAU
    ========================================================== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Barre supérieure --}}
        <div class="px-4 sm:px-6 py-4 border-b border-gray-100 bg-gray-50">

            <div class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-lg bg-orange-100 flex items-center justify-center">
                    <i class="fas fa-truck text-orange-600"></i>
                </div>

                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-800">
                        Fournisseurs
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-500">
                        Liste des fournisseurs enregistrés
                    </p>
                </div>
            </div>

        </div>


        {{-- =====================================================
             RESPONSIVE TABLE
        ====================================================== --}}
        <div class="overflow-x-auto">

            <table class="min-w-[900px] w-full divide-y divide-gray-200">

                {{-- En-tête --}}
                <thead class="bg-orange-500">

                    <tr>

                        <th class="px-3 sm:px-4 py-3 text-left
                                   text-xs font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            N°
                        </th>

                        <th class="px-3 sm:px-4 py-3 text-left
                                   text-xs font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Nom
                        </th>

                        <th class="px-3 sm:px-4 py-3 text-left
                                   text-xs font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Email
                        </th>

                        <th class="px-3 sm:px-4 py-3 text-left
                                   text-xs font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Téléphone
                        </th>

                        <th class="px-3 sm:px-4 py-3 text-left
                                   text-xs font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Adresse
                        </th>

                        <th class="px-3 sm:px-4 py-3 text-center
                                   text-xs font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Actions
                        </th>

                    </tr>

                </thead>


                {{-- Corps --}}
                <tbody class="bg-white divide-y divide-gray-100">

                    @forelse($fournisseurs as $fournisseur)

                    <tr class="hover:bg-orange-50/40 transition duration-150">

                        {{-- N° --}}
                        <td class="px-3 sm:px-4 py-3 text-sm font-semibold text-gray-600 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>


                        {{-- Nom --}}
                        <td class="px-3 sm:px-4 py-3 text-sm font-semibold text-gray-800 whitespace-nowrap">
                            {{ $fournisseur->nom_fournisseur }}
                        </td>


                        {{-- Email --}}
                        <td class="px-3 sm:px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                            {{ $fournisseur->email ?: '-' }}
                        </td>


                        {{-- Téléphone --}}
                        <td class="px-3 sm:px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                            {{ $fournisseur->contact_fournisseur ?: '-' }}
                        </td>


                        {{-- Adresse --}}
                        <td class="px-3 sm:px-4 py-3 text-sm text-gray-600">
                            <div class="max-w-xs truncate"
                                 title="{{ $fournisseur->adresse_fournisseur }}">
                                {{ $fournisseur->adresse_fournisseur ?: '-' }}
                            </div>
                        </td>


                        {{-- Actions --}}
                        <td class="px-3 sm:px-4 py-3">

                            <div class="flex items-center justify-center gap-1.5">

                                {{-- Voir --}}
                                <a href="{{ route('fournisseurs.show', $fournisseur->id) }}"
                                   title="Voir"
                                   class="inline-flex items-center justify-center
                                          w-9 h-9
                                          bg-indigo-500 hover:bg-indigo-600
                                          text-white rounded-lg
                                          transition duration-200
                                          shadow-sm">

                                    <i class="fas fa-eye text-sm"></i>

                                </a>


                                {{-- Modifier --}}
                                <a href="{{ route('fournisseurs.edit', $fournisseur->id) }}"
                                   title="Modifier"
                                   class="inline-flex items-center justify-center
                                          w-9 h-9
                                          bg-yellow-500 hover:bg-yellow-600
                                          text-white rounded-lg
                                          transition duration-200
                                          shadow-sm">

                                    <i class="fas fa-edit text-sm"></i>

                                </a>


                                {{-- Supprimer --}}
                                <form action="{{ route('fournisseurs.destroy', $fournisseur->id) }}"
                                      method="POST"
                                      class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            title="Supprimer"
                                            class="inline-flex items-center justify-center
                                                   w-9 h-9
                                                   bg-red-500 hover:bg-red-600
                                                   text-white rounded-lg
                                                   transition duration-200
                                                   shadow-sm"
                                            onclick="return confirm('Voulez-vous vraiment supprimer ce fournisseur ?')">

                                        <i class="fas fa-trash text-sm"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
                            class="px-4 py-12 text-center">

                            <div class="flex flex-col items-center justify-center">

                                <div class="w-14 h-14 rounded-full bg-gray-100
                                            flex items-center justify-center mb-3">

                                    <i class="fas fa-truck text-gray-400 text-xl"></i>

                                </div>

                                <p class="text-sm sm:text-base
                                          font-semibold text-gray-600">
                                    Aucun fournisseur trouvé
                                </p>

                                <p class="text-xs sm:text-sm text-gray-400 mt-1">
                                    Commencez par ajouter un fournisseur.
                                </p>

                                <a href="{{ route('fournisseurs.create') }}"
                                   class="mt-4 inline-flex items-center gap-2
                                          bg-blue-600 hover:bg-blue-700
                                          text-white font-semibold
                                          px-4 py-2 rounded-lg
                                          text-sm transition">

                                    <i class="fas fa-plus"></i>
                                    Ajouter un fournisseur

                                </a>

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
        @if($fournisseurs->hasPages())

            <div class="px-4 sm:px-6 py-4 border-t border-gray-100
                        bg-gray-50 overflow-x-auto">

                {{ $fournisseurs->links() }}

            </div>

        @endif

    </div>

</div>

@endsection