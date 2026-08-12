<header
    class="
        sticky
        top-0
        z-30

        w-full
        min-h-[64px]

        bg-white
        dark:bg-gray-900

        border-b
        border-gray-200
        dark:border-gray-700

        shadow-sm
    "
>

    <div
        class="
            w-full
            min-h-[64px]

            flex
            items-center

            gap-2
            sm:gap-3
            lg:gap-4

            px-3
            sm:px-4
            lg:px-6
        "
    >


        <!-- =================================================
             BOUTON MENU MOBILE / TABLETTE
        ================================================== -->

        <button
            type="button"
            @click="sidebarOpen = true"
            class="
                lg:hidden

                flex-shrink-0

                w-10
                h-10
                sm:w-11
                sm:h-11

                flex
                items-center
                justify-center

                rounded-xl

                bg-[#1e293b]
                text-white

                shadow-sm

                hover:bg-blue-900

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


        <!-- =================================================
             LOGO / NOM
        ================================================== -->

        <a
            href="{{ auth()->user()->isSuperAdmin()
                ? route('super-admin.dashboard')
                : route('dashboard') }}"
            class="
                flex
                items-center
                gap-2

                min-w-0

                flex-shrink-0
            "
        >

            <!-- Logo -->

            <img
                src="/build/assets/ChatGPT%20Image%2020%20janv.%202026,%2012_59_37.png"
                alt="KorNet"
                class="
                    hidden
                    sm:block

                    h-9
                    w-9

                    lg:h-10
                    lg:w-10

                    rounded-full

                    object-cover

                    shadow
                "
            >


            <!-- Nom -->

            <span
                class="
                    text-base
                    sm:text-lg
                    lg:text-xl

                    font-extrabold
                    tracking-wide

                    text-gray-800
                    dark:text-white

                    truncate
                "
            >
                KorNet
            </span>

        </a>


        <!-- =================================================
             RECHERCHE
        ================================================== -->

        <form
            action="{{ route('produits.index') }}"
            method="GET"
            class="
                relative

                flex-1

                min-w-0

                max-w-none
                lg:max-w-xl

                hidden
                sm:block
            "
        >

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Rechercher un produit..."
                class="
                    w-full

                    pl-10
                    pr-4

                    py-2
                    sm:py-2.5

                    rounded-lg

                    border
                    border-gray-300
                    dark:border-gray-600

                    bg-gray-100
                    dark:bg-gray-700

                    text-gray-700
                    dark:text-white

                    text-sm

                    placeholder-gray-400

                    focus:outline-none
                    focus:ring-2
                    focus:ring-blue-500
                    focus:border-transparent

                    transition
                "
            />

            <!-- Icône recherche -->

            <span
                class="
                    absolute
                    left-3
                    top-1/2
                    -translate-y-1/2

                    text-gray-400

                    pointer-events-none
                "
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >

                    <circle
                        cx="11"
                        cy="11"
                        r="8"
                    />

                    <line
                        x1="21"
                        y1="21"
                        x2="16.65"
                        y2="16.65"
                    />

                </svg>

            </span>

        </form>


        <!-- =================================================
             ESPACE FLEXIBLE
        ================================================== -->

        <div class="flex-1 min-w-0"></div>


        <!-- =================================================
             ACTIONS
        ================================================== -->

        <div
            class="
                flex
                items-center
                gap-1
                sm:gap-2

                flex-shrink-0
            "
        >


            <!-- =============================================
                 RECHERCHE MOBILE
            ============================================== -->

            <a
                href="{{ route('produits.index') }}"
                class="
                    sm:hidden

                    flex
                    items-center
                    justify-center

                    w-9
                    h-9

                    rounded-full

                    text-gray-500
                    dark:text-gray-300

                    hover:bg-gray-100
                    dark:hover:bg-gray-700

                    transition
                "
                aria-label="Rechercher"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >

                    <circle
                        cx="11"
                        cy="11"
                        r="8"
                    />

                    <line
                        x1="21"
                        y1="21"
                        x2="16.65"
                        y2="16.65"
                    />

                </svg>

            </a>


            <!-- =============================================
                 NOTIFICATIONS
            ============================================== -->

            <div
                x-data="{ open: false }"
                class="relative"
            >

                <button
                    type="button"
                    @click="open = !open"
                    class="
                        relative

                        flex
                        items-center
                        justify-center

                        w-9
                        h-9
                        sm:w-10
                        sm:h-10

                        rounded-full

                        text-gray-500
                        dark:text-gray-300

                        hover:bg-gray-100
                        dark:hover:bg-gray-700

                        focus:outline-none
                        focus:ring-2
                        focus:ring-blue-400

                        transition
                    "
                    aria-label="Notifications"
                >

                    <svg
                        class="h-5 w-5 sm:h-6 sm:w-6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                        />

                    </svg>


                    <!-- Badge -->

                    <span
                        class="
                            absolute
                            top-1
                            right-1

                            h-2
                            w-2

                            rounded-full

                            bg-red-500

                            ring-2
                            ring-white
                            dark:ring-gray-900
                        "
                    ></span>

                </button>


                <!-- =========================================
                     DROPDOWN NOTIFICATIONS
                ========================================== -->

                <div
                    x-show="open"
                    x-transition
                    @click.away="open = false"
                    class="
                        absolute

                        right-0
                        mt-2

                        w-[280px]
                        sm:w-80

                        max-w-[calc(100vw-24px)]

                        bg-white
                        dark:bg-gray-800

                        rounded-xl

                        shadow-2xl

                        ring-1
                        ring-black/5

                        overflow-hidden

                        z-[100]
                    "
                    style="display: none;"
                >

                    <!-- Titre -->

                    <div
                        class="
                            px-4
                            py-3

                            border-b
                            border-gray-100
                            dark:border-gray-700

                            text-gray-700
                            dark:text-gray-200

                            text-sm
                        "
                    >

                        <span class="font-semibold">
                            Notifications
                        </span>

                    </div>


                    <!-- Liste -->

                    <div class="max-h-64 overflow-y-auto">

                        @if(!empty($notifications))

                            @foreach($notifications as $notif)

                                <div
                                    class="
                                        px-4
                                        py-3

                                        text-sm

                                        text-gray-700
                                        dark:text-gray-200

                                        hover:bg-gray-100
                                        dark:hover:bg-gray-700

                                        transition

                                        cursor-pointer
                                    "
                                >

                                    {{ $notif }}

                                </div>

                            @endforeach

                        @else

                            <div
                                class="
                                    px-4
                                    py-6

                                    text-sm

                                    text-gray-400

                                    text-center
                                "
                            >

                                Aucune notification

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            <!-- =============================================
                 PARAMÈTRES
            ============================================== -->

            <a
                href="{{ route('profile.edit') }}"
                class="
                    hidden
                    sm:flex

                    items-center
                    justify-center

                    w-10
                    h-10

                    rounded-full

                    text-gray-500
                    dark:text-gray-300

                    hover:bg-gray-100
                    dark:hover:bg-gray-700

                    focus:outline-none
                    focus:ring-2
                    focus:ring-blue-400

                    transition
                "
                aria-label="Paramètres"
            >

                <svg
                    class="h-5 w-5 sm:h-6 sm:w-6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >

                    <circle
                        cx="12"
                        cy="12"
                        r="3"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 007 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 003 15.6V15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 005 7.6a1.65 1.65 0 00.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 5.6V5a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09A1.65 1.65 0 0017 4.6a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9H21a2 2 0 010 4h-.09A1.65 1.65 0 0019.4 15z"
                    />

                </svg>

            </a>


            <!-- =============================================
                 UTILISATEUR
            ============================================== -->

            @auth

                <div
                    class="
                        flex
                        items-center
                        gap-2
                    "
                >

                    <!-- Avatar -->

                    <a
                        href="{{ route('profile.edit') }}"
                        class="flex-shrink-0"
                    >

                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff"
                            alt="Avatar de {{ Auth::user()->name }}"
                            class="
                                h-9
                                w-9
                                sm:h-10
                                sm:w-10

                                rounded-full

                                border-2
                                border-gray-300
                                dark:border-gray-600

                                shadow

                                object-cover
                            "
                        >

                    </a>


                    <!-- Nom -->

                    <div class="hidden md:block min-w-0">

                        <div
                            class="
                                font-semibold

                                text-gray-700
                                dark:text-gray-200

                                text-xs

                                max-w-[110px]
                                lg:max-w-[150px]

                                truncate
                            "
                        >

                            {{ Auth::user()->name }}

                        </div>

                    </div>

                </div>

            @endauth


            <!-- =============================================
                 MENU UTILISATEUR
            ============================================== -->

            <x-dropdown align="right" width="48">

                <x-slot name="trigger">

                    <button
                        type="button"
                        class="
                            flex
                            items-center
                            justify-center

                            w-9
                            h-9

                            rounded-lg

                            text-gray-500
                            dark:text-gray-400

                            hover:bg-gray-100
                            dark:hover:bg-gray-700

                            focus:outline-none
                            focus:ring-2
                            focus:ring-blue-400

                            transition
                        "
                        aria-label="Menu utilisateur"
                    >

                        <svg
                            class="fill-current h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >

                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />

                        </svg>

                    </button>

                </x-slot>


                <x-slot name="content">

                    <x-dropdown-link :href="route('profile.edit')">
                        Profil
                    </x-dropdown-link>


                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="
                                w-full
                                text-left

                                px-4
                                py-2

                                text-sm

                                text-gray-700
                                dark:text-gray-200

                                hover:bg-gray-100
                                dark:hover:bg-gray-700

                                transition
                            "
                        >
                            Déconnexion
                        </button>

                    </form>

                </x-slot>

            </x-dropdown>

        </div>

    </div>

</header>

