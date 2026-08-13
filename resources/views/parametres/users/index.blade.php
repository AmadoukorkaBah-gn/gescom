@extends('layouts.app')

@section('content')
<div class="w-full px-3 sm:px-4 lg:px-6 xl:px-8 py-5 sm:py-6">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 tracking-tight">
                Gestion des Utilisateurs
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Gérez les comptes et les rôles des utilisateurs.
            </p>
        </div>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('users.create') }}"
               class="inline-flex items-center justify-center gap-2
                      w-full sm:w-auto
                      bg-blue-600 hover:bg-blue-700
                      text-white font-semibold
                      px-4 py-2.5
                      rounded-lg shadow-sm
                      transition duration-200">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>

                <span>Ajouter un utilisateur</span>
            </a>
        @endif
    </div>


    {{-- =========================================================
         MESSAGE SUCCÈS
    ========================================================== --}}
    @if(session('success'))
        <div class="mb-5 flex items-start gap-3
                    bg-green-50 border border-green-200
                    text-green-800
                    px-4 py-3 rounded-xl shadow-sm">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5 flex-shrink-0 mt-0.5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7"/>
            </svg>

            <span class="text-sm sm:text-base font-medium">
                {{ session('success') }}
            </span>
        </div>
    @endif


    {{-- =========================================================
         MESSAGE ERREUR
    ========================================================== --}}
    @if(session('error'))
        <div class="mb-5 flex items-start gap-3
                    bg-red-50 border border-red-200
                    text-red-800
                    px-4 py-3 rounded-xl shadow-sm">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5 flex-shrink-0 mt-0.5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>

            <span class="text-sm sm:text-base font-medium">
                {{ session('error') }}
            </span>
        </div>
    @endif


    {{-- =========================================================
         TABLEAU
    ========================================================== --}}
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">

        {{-- Zone de défilement horizontal sur mobile --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[850px] divide-y divide-gray-200">

                {{-- =================================================
                     EN-TÊTE
                ================================================== --}}
                <thead class="bg-orange-500">

                    <tr>

                        <th class="px-3 sm:px-4 py-3.5
                                   text-left text-[11px] sm:text-xs
                                   font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            N°
                        </th>

                        <th class="px-3 sm:px-4 py-3.5
                                   text-left text-[11px] sm:text-xs
                                   font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Nom
                        </th>

                        <th class="px-3 sm:px-4 py-3.5
                                   text-left text-[11px] sm:text-xs
                                   font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Email
                        </th>

                        <th class="px-3 sm:px-4 py-3.5
                                   text-left text-[11px] sm:text-xs
                                   font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Rôle
                        </th>

                        <th class="px-3 sm:px-4 py-3.5
                                   text-left text-[11px] sm:text-xs
                                   font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Créé le
                        </th>

                        <th class="px-3 sm:px-4 py-3.5
                                   text-left text-[11px] sm:text-xs
                                   font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Actions
                        </th>

                    </tr>

                </thead>


                {{-- =================================================
                     CORPS
                ================================================== --}}
                <tbody class="bg-white divide-y divide-gray-100">

                    @forelse($users as $user)

                        <tr class="hover:bg-gray-50 transition duration-150">

                            {{-- N° --}}
                            <td class="px-3 sm:px-4 py-3.5
                                       text-sm text-gray-600
                                       whitespace-nowrap">

                                {{ $loop->iteration }}

                            </td>


                            {{-- NOM --}}
                            <td class="px-3 sm:px-4 py-3.5
                                       text-sm font-semibold text-gray-800
                                       whitespace-nowrap">

                                {{ $user->name }}

                            </td>


                            {{-- EMAIL --}}
                            <td class="px-3 sm:px-4 py-3.5
                                       text-sm text-gray-600
                                       whitespace-nowrap">

                                {{ $user->email }}

                            </td>


                            {{-- RÔLE --}}
                            <td class="px-3 sm:px-4 py-3.5
                                       text-sm whitespace-nowrap">

                                @php
                                    $roleColors = [
                                        'admin' => 'bg-purple-100 text-purple-800 ring-purple-200',
                                        'gestionnaire' => 'bg-blue-100 text-blue-800 ring-blue-200',
                                        'vendeur' => 'bg-green-100 text-green-800 ring-green-200',
                                    ];
                                @endphp

                                <span class="inline-flex items-center
                                             px-2.5 py-1
                                             text-xs font-semibold
                                             rounded-full ring-1 ring-inset
                                             {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-700 ring-gray-200' }}">

                                    {{ ucfirst($user->role) }}

                                </span>

                            </td>


                            {{-- DATE --}}
                            <td class="px-3 sm:px-4 py-3.5
                                       text-sm text-gray-600
                                       whitespace-nowrap">

                                {{ $user->created_at->format('d/m/Y') }}

                            </td>


                            {{-- ACTIONS --}}
                            <td class="px-3 sm:px-4 py-3.5">

                                <div class="flex items-center gap-2">

                                    {{-- MODIFIER --}}
                                    <a href="{{ route('users.edit', $user) }}"
                                       title="Modifier"
                                       class="inline-flex items-center justify-center
                                              w-9 h-9
                                              bg-yellow-100
                                              text-yellow-700
                                              rounded-lg
                                              hover:bg-yellow-200
                                              transition duration-200">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="w-4.5 h-4.5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M15.232 5.232l3.536 3.536
                                                     M9 13.5V15h1.5l7.5-7.5
                                                     -1.5-1.5L9 13.5z"/>

                                        </svg>

                                    </a>


                                    {{-- SUPPRIMER --}}
                                    @if($user->id !== auth()->id() && $user->parent_id === auth()->id())

                                        <form method="POST"
                                              action="{{ route('users.destroy', $user) }}"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    title="Supprimer"
                                                    class="inline-flex items-center justify-center
                                                           w-9 h-9
                                                           bg-red-100
                                                           text-red-700
                                                           rounded-lg
                                                           hover:bg-red-200
                                                           transition duration-200">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="w-4.5 h-4.5"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7
                                                             m5 4v6
                                                             m4-6v6
                                                             M1 7h22
                                                             M10 2h4a1 1 0 011 1v1H9V3a1 1 0 011-1z"/>

                                                </svg>

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-4 py-10 text-center">

                                <div class="flex flex-col items-center justify-center">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-12 h-12 text-gray-300 mb-3"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.5"
                                              d="M17 20h5v-2a4 4 0 00-4-4h-1
                                                 M9 20H4v-2a4 4 0 014-4h1
                                                 M12 12a4 4 0 100-8 4 4 0 000 8z"/>

                                    </svg>

                                    <p class="text-gray-500 text-sm font-medium">
                                        Aucun utilisateur trouvé.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection