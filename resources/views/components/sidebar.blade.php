@php
    $user = auth()->user();
@endphp

<div

    x-data="{}"

    x-effect="document.body.classList.toggle('overflow-hidden', $store.layout.sidebarOpen)"

    @keydown.escape.window="$store.layout.closeSidebar()"

    class="relative"
>


    <!-- =====================================================
         BOUTON MENU MOBILE / TABLETTE
    ====================================================== -->

    <button
        type="button"

        x-show="!$store.layout.sidebarOpen"
        x-transition.opacity

        @click="$store.layout.sidebarOpen = true"

        class="
            lg:hidden
            fixed
            top-3
            left-3
            z-[70]

            w-11
            h-11

            flex
            items-center
            justify-center

            rounded-xl

            bg-[#1e293b]
            text-white

            shadow-lg

            hover:bg-blue-900
            active:scale-95

            focus:outline-none
            focus:ring-2
            focus:ring-blue-400

            transition
        "

        aria-label="Ouvrir le menu"
    >

        <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
        >

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M4 6h16M4 12h16M4 18h16"
            />

        </svg>

    </button>


    <!-- =====================================================
         OVERLAY MOBILE / TABLETTE
    ====================================================== -->

    <div
        x-show="$store.layout.sidebarOpen"

        x-transition:enter="transition-opacity duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"

        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"

        @click="$store.layout.closeSidebar()"

        class="
            fixed
            inset-0

            z-[55]

            bg-black/50
            backdrop-blur-[2px]

            lg:hidden
        "

        style="display: none;"
    ></div>


    <!-- =====================================================
         SIDEBAR
    ====================================================== -->

    <aside
        :class="{
            'translate-x-0': $store.layout.sidebarOpen,
            '-translate-x-full': !$store.layout.sidebarOpen,

            'lg:translate-x-0': true,

            'lg:w-20': $store.layout.sidebarCollapsed,
            'lg:w-56': !$store.layout.sidebarCollapsed
        }"

        class="
            fixed

            top-0
            left-0
            bottom-0

            z-[60]

            w-[min(82vw,280px)]

            bg-[#1e293b]
            text-white

            shadow-2xl

            flex
            flex-col

            overflow-hidden

            transform

            transition-all
            duration-300
            ease-in-out

            lg:shadow-xl
        "
    >


        <!-- =================================================
             LOGO + BOUTONS
        ================================================== -->

        <div
            class="
                h-[72px]
                min-h-[72px]

                flex-shrink-0

                flex
                items-center
                justify-between

                gap-2
                px-3

                border-b
                border-white/10
            "
        >


            <!-- =================================================
                 LOGO
            ================================================== -->

            <a
                href="{{ $user->isSuperAdmin()
                    ? route('super-admin.dashboard')
                    : route('dashboard') }}"

                class="
                    flex
                    items-center
                    gap-3

                    min-w-0
                    flex-1

                    overflow-hidden
                "
            >

                <img
    src="{{ asset('images/logo.png') }}"
    class="
        h-11
        w-11
        sm:h-12
        sm:w-12
        rounded-full
        object-cover
        flex-shrink-0
        shadow-lg
    "
>


                <span
                    x-show="!$store.layout.sidebarCollapsed"

                    x-transition.opacity

                    class="
                        text-lg
                        sm:text-xl

                        font-extrabold
                        tracking-widest

                        text-white

                        truncate
                    "
                >
                    KorNet
                </span>

            </a>


            <!-- =================================================
                 BOUTON REDUIRE DESKTOP
            ================================================== -->

            <button
                type="button"

                @click="$store.layout.toggleCollapse()"

                class="
                    hidden
                    lg:flex

                    flex-shrink-0

                    w-9
                    h-9

                    items-center
                    justify-center

                    rounded-lg

                    text-white

                    hover:bg-white/10

                    focus:outline-none
                    focus:ring-2
                    focus:ring-white/20

                    transition
                "

                :title="$store.layout.sidebarCollapsed
                    ? 'Agrandir le menu'
                    : 'Réduire le menu'"
            >

                <!-- SIDEBAR OUVERT -->

                <svg
                    x-show="!$store.layout.sidebarCollapsed"
                    x-transition.opacity

                    class="w-5 h-5"

                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"

                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"

                        d="M11 19l-7-7 7-7M4 12h16"
                    />

                </svg>


                <!-- SIDEBAR RÉDUIT -->

                <svg
                    x-show="$store.layout.sidebarCollapsed"
                    x-transition.opacity

                    class="w-5 h-5"

                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"

                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"

                        d="M13 5l7 7-7 7M20 12H4"
                    />

                </svg>

            </button>


            <!-- =================================================
                 BOUTON FERMER MOBILE
            ================================================== -->

            <button
                type="button"

                @click="$store.layout.closeSidebar()"

                class="
                    lg:hidden

                    flex-shrink-0

                    w-9
                    h-9

                    flex
                    items-center
                    justify-center

                    rounded-lg

                    text-white

                    hover:bg-white/10
                    active:bg-white/20

                    focus:outline-none

                    transition
                "

                aria-label="Fermer le menu"
            >

                <svg
                    class="w-6 h-6"

                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"

                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"

                        d="M6 18L18 6M6 6l12 12"
                    />

                </svg>

            </button>

        </div>


        <!-- =================================================
             MENU SCROLLABLE
        ================================================== -->

        <nav
            class="
                flex-1
                min-h-0

                overflow-y-auto
                overflow-x-hidden

                px-2
                py-3

                pb-4

                overscroll-contain

                scrollbar-thin
            "
        >


            <!-- =================================================
                 DASHBOARD
            ================================================== -->

            <div class="px-1 py-1">

                @if($user->isSuperAdmin())

                    <a
                        href="{{ route('super-admin.dashboard') }}"

                        @click="$store.layout.closeSidebar()"

                        class="
                            flex
                            items-center
                            gap-2

                            px-3
                            py-2.5

                            rounded-lg

                            text-sm
                            font-medium

                            text-white

                            hover:bg-blue-900

                            transition
                        "
                    >

                        <span class="flex-shrink-0 text-lg">
                            🏠
                        </span>

                        <span
                            x-show="!$store.layout.sidebarCollapsed"
                            x-transition.opacity

                            class="truncate"
                        >
                            Tableau de bord
                        </span>

                    </a>

                @else

                    <a
                        href="{{ route('dashboard') }}"

                        @click="$store.layout.closeSidebar()"

                        class="
                            flex
                            items-center
                            gap-2

                            px-3
                            py-2.5

                            rounded-lg

                            text-sm
                            font-medium

                            text-white

                            hover:bg-blue-900

                            transition
                        "
                    >

                        <span class="flex-shrink-0 text-lg">
                            🏠
                        </span>

                        <span
                            x-show="!$store.layout.sidebarCollapsed"
                            x-transition.opacity

                            class="truncate"
                        >
                            Tableau de bord
                        </span>

                    </a>

                @endif


                <div
                    x-show="!$store.layout.sidebarCollapsed"

                    class="
                        mt-2
                        border-t
                        border-white/10
                    "
                ></div>

            </div>


            <!-- =================================================
                 VENTES
            ================================================== -->

            @if(!$user->isSuperAdmin() && $user->canAccess('ventes'))

                <div
                    x-data="{ open: true }"
                    class="mt-3"
                >

                    <button
                        type="button"

                        @click="open = !open"

                        class="sidebar-section"
                    >

                        <div
                            class="
                                flex
                                items-center
                                gap-2
                                min-w-0
                            "
                        >

                            <span class="flex-shrink-0 text-lg">
                                🧾
                            </span>

                            <span
                                x-show="!$store.layout.sidebarCollapsed"
                                x-transition.opacity

                                class="truncate"
                            >
                                Ventes
                            </span>

                        </div>


                        <svg
                            x-show="!$store.layout.sidebarCollapsed"

                            :class="{
                                'rotate-180': open
                            }"

                            class="
                                h-4
                                w-4

                                flex-shrink-0

                                transition-transform
                            "

                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"

                                d="M19 9l-7 7-7-7"
                            />

                        </svg>

                    </button>


                    <div
                        x-show="open && !$store.layout.sidebarCollapsed"
                        x-transition

                        class="
                            mt-1
                            space-y-1
                        "
                    >

                        <a
                            href="{{ route('ventes.create') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            ➕ Nouvelle vente
                        </a>

                        <a
                            href="{{ route('ventes.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            📄 Liste des ventes
                        </a>
                         
<a
    href="{{ route('ventes.credit') }}"
    @click="$store.layout.closeSidebar()"
    class="sidebar-link"
>
    💳 Ventes à crédit
</a>


                        <a
                            href="{{ route('retours.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            ↩️ Retours
                        </a>

                    </div>

                </div>

            @endif


            <!-- =================================================
                 PRODUITS
            ================================================== -->

            @if(!$user->isSuperAdmin() && $user->canAccess('produits'))

                <div
                    x-data="{ open: false }"
                    class="mt-3"
                >

                    <button
                        type="button"

                        @click="open = !open"

                        class="sidebar-section"
                    >

                        <div class="flex items-center gap-2 min-w-0">

                            <span class="flex-shrink-0 text-lg">
                                📦
                            </span>

                            <span
                                x-show="!$store.layout.sidebarCollapsed"
                                x-transition.opacity

                                class="truncate"
                            >
                                Produits
                            </span>

                        </div>


                        <svg
                            x-show="!$store.layout.sidebarCollapsed"

                            :class="{
                                'rotate-180': open
                            }"

                            class="
                                h-4
                                w-4
                                flex-shrink-0
                                transition-transform
                            "

                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"

                                d="M19 9l-7 7-7-7"
                            />

                        </svg>

                    </button>


                    <div
                        x-show="open && !$store.layout.sidebarCollapsed"
                        x-transition

                        class="
                            mt-1
                            space-y-1
                        "
                    >

                        <a
                            href="{{ route('produits.create') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            ➕ Ajouter produit
                        </a>

                        <a
                            href="{{ route('produits.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            📋 Liste des produits
                        </a>

                        <a
                            href="{{ route('stocks.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            🏬 État du stock
                        </a>
                         
        <a
          href="{{ route('inventaire.index') }}"
          @click="$store.layout.closeSidebar()"
        class="sidebar-link"
        >
       📦 Inventaire
      </a> 


                        <a
                            href="{{ route('stocks.mouvements') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            📈 Mouvements de stock
                        </a>

                        <a
                            href="{{ route('categorie.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            🏷️ Catégories
                        </a>

                    </div>

                </div>

            @endif


            <!-- =================================================
                 APPROVISIONNEMENT
            ================================================== -->

            @if(!$user->isSuperAdmin() && $user->canAccess('achats'))

                <div
                    x-data="{ open: false }"
                    class="mt-3"
                >

                    <button
                        type="button"

                        @click="open = !open"

                        class="sidebar-section"
                    >

                        <div class="flex items-center gap-2 min-w-0">

                            <span class="flex-shrink-0 text-lg">
                                🛒
                            </span>

                            <span
                                x-show="!$store.layout.sidebarCollapsed"
                                x-transition.opacity

                                class="truncate"
                            >
                                Approvisionnement
                            </span>

                        </div>


                        <svg
                            x-show="!$store.layout.sidebarCollapsed"

                            :class="{
                                'rotate-180': open
                            }"

                            class="
                                h-4
                                w-4
                                flex-shrink-0
                                transition-transform
                            "

                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"

                                d="M19 9l-7 7-7-7"
                            />

                        </svg>

                    </button>


                    <div
                        x-show="open && !$store.layout.sidebarCollapsed"
                        x-transition

                        class="mt-1 space-y-1"
                    >

                        <a
                            href="{{ route('achats.create') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            ➕ Nouvel achat
                        </a>

                        <a
                            href="{{ route('achats.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            📋 Liste des achats
                        </a>

                    </div>

                </div>

            @endif


            <!-- =================================================
                 COMPTABILITÉ
            ================================================== -->

            @if(!$user->isSuperAdmin() && $user->canAccess('comptabilite'))

                <div
                    x-data="{ open: false }"
                    class="mt-3"
                >

                    <button
                        type="button"

                        @click="open = !open"

                        class="sidebar-section"
                    >

                        <div class="flex items-center gap-2 min-w-0">

                            <span class="flex-shrink-0 text-lg">
                                💼
                            </span>

                            <span
                                x-show="!$store.layout.sidebarCollapsed"
                                x-transition.opacity

                                class="truncate"
                            >
                                Comptabilité
                            </span>

                        </div>


                        <svg
                            x-show="!$store.layout.sidebarCollapsed"

                            :class="{
                                'rotate-180': open
                            }"

                            class="
                                h-4
                                w-4
                                flex-shrink-0
                                transition-transform
                            "

                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"

                                d="M19 9l-7 7-7-7"
                            />

                        </svg>

                    </button>


                    <div
                        x-show="open && !$store.layout.sidebarCollapsed"
                        x-transition

                        class="mt-1 space-y-1"
                    >

                        <a
                            href="{{ route('caisses.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            💰 Caisses
                        </a>

                        <a
                            href="{{ route('recettes.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            📈 Recettes
                        </a>

                        <a
                            href="{{ route('depenses.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            📉 Dépenses
                        </a>

                        <a
                            href="{{ route('dettes.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            📋 Dettes / Créances
                        </a>

                    </div>

                </div>

            @endif


            <!-- =================================================
                 RAPPORTS
            ================================================== -->

            @if(!$user->isSuperAdmin() && $user->canAccess('rapports'))

                <div
                    x-data="{ open: false }"
                    class="mt-3"
                >

                    <button
                        type="button"

                        @click="open = !open"

                        class="sidebar-section"
                    >

                        <div class="flex items-center gap-2 min-w-0">

                            <span class="flex-shrink-0 text-lg">
                                📊
                            </span>

                            <span
                                x-show="!$store.layout.sidebarCollapsed"
                                x-transition.opacity

                                class="truncate"
                            >
                                Rapports
                            </span>

                        </div>


                        <svg
                            x-show="!$store.layout.sidebarCollapsed"

                            :class="{
                                'rotate-180': open
                            }"

                            class="
                                h-4
                                w-4
                                flex-shrink-0
                                transition-transform
                            "

                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"

                                d="M19 9l-7 7-7-7"
                            />

                        </svg>

                    </button>


                    <div
                        x-show="open && !$store.layout.sidebarCollapsed"
                        x-transition

                        class="mt-1 space-y-1"
                    >

                        <a
                            href="{{ route('rapports.ventes-par-periode') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            📆 Ventes par période
                        </a>

                        <a
                            href="{{ route('rapports.chiffre-affaires') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            💰 Chiffre d'affaires
                        </a>

                        <a
                            href="{{ route('rapports.produits-plus-vendus') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            🔥 Produits les plus vendus
                        </a>

                    </div>

                </div>

            @endif


            <!-- =================================================
                 FOURNISSEURS
            ================================================== -->

            @if(!$user->isSuperAdmin() && $user->canAccess('fournisseurs'))

                <div
                    x-data="{ open: false }"
                    class="mt-3"
                >

                    <button
                        type="button"

                        @click="open = !open"

                        class="sidebar-section"
                    >

                        <div class="flex items-center gap-2 min-w-0">

                            <span class="flex-shrink-0 text-lg">
                                🏢
                            </span>

                            <span
                                x-show="!$store.layout.sidebarCollapsed"
                                x-transition.opacity

                                class="truncate"
                            >
                                Fournisseurs
                            </span>

                        </div>


                        <svg
                            x-show="!$store.layout.sidebarCollapsed"

                            :class="{
                                'rotate-180': open
                            }"

                            class="
                                h-4
                                w-4
                                flex-shrink-0
                                transition-transform
                            "

                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"

                                d="M19 9l-7 7-7-7"
                            />

                        </svg>

                    </button>


                    <div
                        x-show="open && !$store.layout.sidebarCollapsed"
                        x-transition

                        class="mt-1 space-y-1"
                    >

                        <a
                            href="{{ route('fournisseurs.create') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            ➕ Ajouter fournisseur
                        </a>

                        <a
                            href="{{ route('fournisseurs.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            📋 Liste des fournisseurs
                        </a>

                    </div>

                </div>

            @endif


            <!-- =================================================
                 CLIENTS
            ================================================== -->

            @if(!$user->isSuperAdmin() && $user->canAccess('clients'))

                <div
                    x-data="{ open: false }"
                    class="mt-3"
                >

                    <button
                        type="button"

                        @click="open = !open"

                        class="sidebar-section"
                    >

                        <div class="flex items-center gap-2 min-w-0">

                            <span class="flex-shrink-0 text-lg">
                                👥
                            </span>

                            <span
                                x-show="!$store.layout.sidebarCollapsed"
                                x-transition.opacity

                                class="truncate"
                            >
                                Clients
                            </span>

                        </div>


                        <svg
                            x-show="!$store.layout.sidebarCollapsed"

                            :class="{
                                'rotate-180': open
                            }"

                            class="
                                h-4
                                w-4
                                flex-shrink-0
                                transition-transform
                            "

                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"

                                d="M19 9l-7 7-7-7"
                            />

                        </svg>

                    </button>


                    <div
                        x-show="open && !$store.layout.sidebarCollapsed"
                        x-transition

                        class="mt-1 space-y-1"
                    >

                        <a
                            href="{{ route('clients.create') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            ➕ Ajouter client
                        </a>

                        <a
                            href="{{ route('clients.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            📋 Liste des clients
                        </a>

                    </div>

                </div>

            @endif


            <!-- =================================================
                 SUPER ADMIN
            ================================================== -->

            @if($user->isSuperAdmin())

                <div
                    x-data="{ open: true }"
                    class="mt-3"
                >

                    <button
                        type="button"

                        @click="open = !open"

                        class="sidebar-section"
                    >

                        <div class="flex items-center gap-2 min-w-0">

                            <span class="flex-shrink-0 text-lg">
                                👑
                            </span>

                            <span
                                x-show="!$store.layout.sidebarCollapsed"
                                x-transition.opacity

                                class="truncate"
                            >
                                Super Admin
                            </span>

                        </div>


                        <svg
                            x-show="!$store.layout.sidebarCollapsed"

                            :class="{
                                'rotate-180': open
                            }"

                            class="
                                h-4
                                w-4
                                flex-shrink-0
                                transition-transform
                            "

                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"

                                d="M19 9l-7 7-7-7"
                            />

                        </svg>

                    </button>


                    <div
                        x-show="open && !$store.layout.sidebarCollapsed"
                        x-transition

                        class="mt-1 space-y-1"
                    >

                        <a
                            href="{{ route('super-admin.dashboard') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            📊 Tableau de bord
                        </a>

                        <a
                            href="{{ route('super-admin.admins.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            👥 Gestion Admins
                        </a>

                        <a
                            href="{{ route('super-admin.abonnements.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            💳 Gestion Abonnements
                        </a>

                        <a
                            href="{{ route('super-admin.paiements.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            💰 Paiements
                        </a>

                    </div>

                </div>

            @endif


            <!-- =================================================
                 PARAMÈTRES
            ================================================== -->

            @if(!$user->isSuperAdmin() && $user->canAccess('parametres'))

                <div
                    x-data="{ open: false }"
                    class="mt-3"
                >

                    <button
                        type="button"

                        @click="open = !open"

                        class="sidebar-section"
                    >

                        <div class="flex items-center gap-2 min-w-0">

                            <span class="flex-shrink-0 text-lg">
                                ⚙️
                            </span>

                            <span
                                x-show="!$store.layout.sidebarCollapsed"
                                x-transition.opacity

                                class="truncate"
                            >
                                Paramètres
                            </span>

                        </div>


                        <svg
                            x-show="!$store.layout.sidebarCollapsed"

                            :class="{
                                'rotate-180': open
                            }"

                            class="
                                h-4
                                w-4
                                flex-shrink-0
                                transition-transform
                            "

                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"

                                d="M19 9l-7 7-7-7"
                            />

                        </svg>

                    </button>


                    <div
                        x-show="open && !$store.layout.sidebarCollapsed"
                        x-transition

                        class="mt-1 space-y-1"
                    >

                        <a
                            href="{{ route('users.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            👤 Utilisateurs / Rôles
                        </a>

                        <a
                            href="{{ route('configuration.index') }}"
                            @click="$store.layout.closeSidebar()"
                            class="sidebar-link"
                        >
                            🔧 Configuration
                        </a>

                    </div>

                </div>

            @endif

        </nav>


        <!-- =================================================
             DÉCONNEXION
        ================================================== -->

        <div
            class="
                flex-shrink-0

                border-t
                border-white/10

                p-3

                bg-[#1e293b]
            "
        >

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"

                    class="
                        flex
                        items-center
                        justify-center
                        gap-2

                        w-full

                        px-3
                        py-2.5

                        text-sm
                        text-white

                        hover:bg-red-600/80
                        active:bg-red-700

                        rounded-lg

                        transition
                    "
                >

                    <span class="flex-shrink-0 text-lg">
                        🚪
                    </span>

                    <span
                        x-show="!$store.layout.sidebarCollapsed"
                        x-transition.opacity

                        class="truncate"
                    >
                        Déconnexion
                    </span>

                </button>

            </form>

        </div>

    </aside>

</div>


<!-- =====================================================
     STYLES SIDEBAR
====================================================== -->

<style>

    .sidebar-section {
        width: 100%;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: .5rem;

        padding: .625rem .75rem;

        border-radius: .5rem;

        color: white;

        font-size: .875rem;
        font-weight: 600;

        transition:
            background-color .2s ease,
            color .2s ease;
    }

    .sidebar-section:hover {
        background-color: #1e3a8a;
    }


    .sidebar-link {
        display: flex;
        align-items: center;

        width: 100%;

        padding: .55rem .75rem .55rem 2.25rem;

        border-radius: .5rem;

        color: rgba(255,255,255,.85);

        font-size: .8125rem;

        line-height: 1.25rem;

        transition:
            background-color .2s ease,
            color .2s ease,
            transform .15s ease;
    }

    .sidebar-link:hover {
        background-color: rgba(30,58,138,.8);
        color: white;
    }

    .sidebar-link:active {
        transform: scale(.98);
    }


    /* Scrollbar */

    aside nav::-webkit-scrollbar {
        width: 5px;
    }

    aside nav::-webkit-scrollbar-track {
        background: transparent;
    }

    aside nav::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,.18);
        border-radius: 999px;
    }

    aside nav::-webkit-scrollbar-thumb:hover {
        background: rgba(255,255,255,.3);
    }


    /* Empêche les éléments de sortir horizontalement */

    aside,
    aside * {
        box-sizing: border-box;
    }

</style>