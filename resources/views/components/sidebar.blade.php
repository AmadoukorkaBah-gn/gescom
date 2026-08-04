@php
    $user = auth()->user();
@endphp

<div x-data="{ open: false }" @toggle-sidebar.window="open = !open" class="min-h-screen">

    <!-- Desktop sidebar (fixed) -->
      
    <aside class="hidden sm:flex sm:flex-col sm:w-30 lg:fixed lg:inset-y-0 lg:left-0 lg:w-65 bg-[#1e293b] border-r border-gray-200 dark:border-gray-700 z-30 text-white">

        <!-- Logo KorNet (fixe) -->
        <div class="p-3 border-b border-gray-200 dark:border-gray-700">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-5 justify-start w-full">
                <img src="/build/assets/ChatGPT%20Image%2020%20janv.%202026,%2012_59_37.png" alt="KorNet Logo" class="h-16 w-16 rounded-full shadow-lg" />
                <span class="text-3xl font-extrabold text-white tracking-widest">KorNet</span>
            </a>
        </div>

        <!-- MENU SCROLLABLE -->
        <nav class="px-2 pb-6 overflow-y-auto flex-1">

            <!-- Dashboard -->
            @if($user->isSuperAdmin())
                <div class="px-3 py-2">
                    <a href="{{ route('super-admin.dashboard') }}" class="flex items-center space-x-2 px-3 py-2 bg-[#1e293b] shadow-sm rounded-md text-sm font-medium text-white hover:bg-blue-900 transition">
                        🏠 <span>Tableau de bord</span>
                    </a>
                    <div class="mt-2 border-t border-gray-200 dark:border-gray-700"></div>
                </div>
            @else
                <div class="px-3 py-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-3 py-2 bg-[#1e293b] shadow-sm rounded-md text-sm font-medium text-white hover:bg-blue-900 transition">
                        🏠 <span>Tableau de bord</span>
                    </a>
                    <div class="mt-2 border-t border-gray-200 dark:border-gray-700"></div>
                </div>
            @endif

            <!-- VENTES - Accessible à tous sauf super admin -->
            @if(!$user->isSuperAdmin() && $user->canAccess('ventes'))
            <div x-data="{ open: true }" class="mt-3">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-white hover:bg-blue-900 rounded transition">
                    <div class="flex items-center space-x-2">
                        🧾 <span>Ventes</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" class="mt-2 space-y-1">
                    <a href="{{ route('ventes.create') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">➕ Nouvelle vente</a>
                    <a href="{{ route('ventes.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">📄 Liste des ventes</a>
                    <a href="{{route('retours.index')}}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">↩️ Retours</a>
                </div>
            </div>
            @endif

            <!-- PRODUITS - Admin et Gestionnaire seulement (pas super admin) -->
            @if(!$user->isSuperAdmin() && $user->canAccess('produits'))
            <div x-data="{ open: false }" class="mt-3">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-white hover:bg-blue-900 rounded transition">
                    <div class="flex items-center space-x-2">
                        📦 <span>Produits</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" class="mt-2 space-y-1">
                    <a href="{{ route('produits.create') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">➕ Ajouter produit</a>
                    <a href="{{ route('produits.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">📋 Liste des produits</a>
                    <a href="{{ route('stocks.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">🏬 État du stock</a>
                    <a href="{{ route('stocks.mouvements') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">📈 Mouvements de stock</a>
                    <a href="{{ route('categorie.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">🏷️ Catégories</a>
                </div>
            </div>
            @endif

            <!-- Achats / Approvisionnement - Admin et Gestionnaire seulement (pas super admin) -->
            @if(!$user->isSuperAdmin() && $user->canAccess('achats'))
            <div x-data="{ open: false }" class="mt-3">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-white hover:bg-blue-900 rounded transition">
                    <div class="flex items-center space-x-2">
                        🛒 <span>Approvisionnement</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="open" class="mt-2 space-y-1">
                    <a href="{{ route('achats.create') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">➕ Nouvel achat</a>
                    <a href="{{ route('achats.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">📋 Liste des achats</a>
                </div>
            </div>
            @endif

            <!-- COMPTABILITÉ - Admin seulement (pas super admin) -->
            @if(!$user->isSuperAdmin() && $user->canAccess('comptabilite'))
            <div x-data="{ open: false }" class="mt-4">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-white hover:bg-blue-900 rounded transition">
                    <div class="flex items-center space-x-2">
                        💼 <span>Comptabilité</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="mt-2 space-y-1">
                    <a href="{{ route('caisses.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">💰 Caisses</a>
                    <a href="{{ route('recettes.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">📈 Recettes</a>
                    <a href="{{ route('depenses.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">📉 Dépenses</a>
                    <a href="{{ route('dettes.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">📋 Dettes / Créances</a>
                </div>
            </div>
            @endif

            <!-- RAPPORTS - Admin et Gestionnaire seulement (pas super admin) -->
            @if(!$user->isSuperAdmin() && $user->canAccess('rapports'))
            <div x-data="{ open: false }" class="mt-4">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-white hover:bg-blue-900 rounded transition">
                    <div class="flex items-center space-x-2">
                        📊 <span>Rapports</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" class="mt-2 space-y-1">
                    <a href="{{ route('rapports.ventes-par-periode') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">📆 Ventes par période</a>
                    <a href="{{ route('rapports.chiffre-affaires') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">💰 Chiffre d'affaires</a>
                    <a href="{{ route('rapports.produits-plus-vendus') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">🔥 Produits les plus vendus</a>
                </div>
            </div>
            @endif

            <!-- FOURNISSEURS - Admin seulement (pas super admin) -->
            @if(!$user->isSuperAdmin() && $user->canAccess('fournisseurs'))
            <div x-data="{ open: false }" class="mt-4">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-white hover:bg-blue-900 rounded transition">
                    <div class="flex items-center space-x-2">
                        🏢 <span>Fournisseurs</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" class="mt-2 space-y-1">
                    <a href="{{ route('fournisseurs.create') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">➕ Ajouter fournisseur</a>
                    <a href="{{ route('fournisseurs.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">📋 Liste des fournisseurs</a>
                </div>
            </div>
            @endif

            <!-- CLIENTS - Accessible à tous sauf super admin -->
            @if(!$user->isSuperAdmin() && $user->canAccess('clients'))
            <div x-data="{ open: false }" class="mt-3">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-white hover:bg-blue-900 rounded transition">
                    <div class="flex items-center space-x-2">
                        👥 <span>Clients</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" class="mt-2 space-y-1">
                    <a href="{{ route('clients.create') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">➕ Ajouter client</a>
                    <a href="{{ route('clients.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">📋 Liste des clients</a>
                </div>
            </div>
            @endif

            <!-- SUPER ADMIN - Super Admin seulement -->
            @if($user->isSuperAdmin())
            <div x-data="{ open: true }" class="mt-4">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-white hover:bg-blue-900 rounded transition">
                    <div class="flex items-center space-x-2">
                        👑 <span>Super Admin</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" class="mt-2 space-y-1">
                    <a href="{{ route('super-admin.dashboard') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">📊 Tableau de bord</a>
                    <a href="{{ route('super-admin.admins.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">👥 Gestion Admins</a>
                    <a href="{{ route('super-admin.abonnements.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">💳 Gestion Abonnements</a>
                    <a href="{{ route('super-admin.paiements.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">💰 Paiements</a>
                </div>
            </div>
            @endif

            <!-- PARAMÈTRES - Admin seulement (pas super admin) -->
            @if(!$user->isSuperAdmin() && $user->canAccess('parametres'))
            <div x-data="{ open: false }" class="mt-4">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold text-white hover:bg-blue-900 rounded transition">
                    <div class="flex items-center space-x-2">
                        ⚙️ <span>Paramètres</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" class="mt-2 space-y-1">
                    <a href="{{ route('users.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">👤 Utilisateurs / Rôles</a>
                    <a href="{{ route('configuration.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-blue-900 rounded transition">🔧 Configuration</a>
                </div>
            </div>
            @endif

            <!-- Logout -->
            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4 px-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 w-full text-left px-3 py-2 text-sm text-white hover:bg-blue-900 rounded transition">
                        🚪 <span>Déconnexion</span>
                    </button>
                </form>
            </div>

        </nav>
    </aside>

</div>
