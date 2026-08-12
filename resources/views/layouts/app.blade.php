<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ config('app.name', 'Laravel') }}
    </title>


    <!-- =====================================================
         FONTS
    ====================================================== -->

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet"
    />


    <!-- =====================================================
         SCRIPTS / CSS
    ====================================================== -->

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body
    x-data="{}"

    class="
        font-sans
        antialiased

        bg-gray-100
        dark:bg-gray-900

        text-gray-800
        dark:text-gray-100
    "
>

    @php
        $user = auth()->user();
    @endphp


    <div class="flex min-h-screen">


        <x-sidebar />

        <div
            :class="{
                'lg:ml-20': $store.layout.sidebarCollapsed,
                'lg:ml-56': !$store.layout.sidebarCollapsed
            }"

            class="
                flex-1
                min-w-0
                w-full

                transition-all
                duration-300
                ease-in-out
            "
        >


            <!-- =================================================
                 HEADER
            ================================================== -->

            <header
                class="
                    sticky
                    top-0

                    z-40

                    w-full

                    bg-white
                    dark:bg-gray-800

                    border-b
                    border-gray-200
                    dark:border-gray-700

                    shadow-sm
                "
            >


                <!-- =============================================
                     PREMIÈRE LIGNE DU HEADER

                     MOBILE :
                     ☰ (fourni par la sidebar, position fixe) + TITRE + ACTIONS

                     DESKTOP :
                     TITRE + RECHERCHE + ACTIONS
                ============================================== -->

                <div
                    class="
                        relative

                        min-h-[64px]

                        flex
                        items-center
                        justify-between

                        gap-3

                        px-4
                        sm:px-6
                        lg:px-8

                        py-3
                    "
                >


                    <!-- =========================================
                         TITRE
                    ========================================== -->

                    <div
                        class="
                            min-w-0
                            flex-1

                            pl-12
                            lg:pl-0
                        "
                    >

                        @isset($header)

                            <div
                                class="
                                    text-lg
                                    sm:text-xl
                                    lg:text-2xl

                                    font-semibold

                                    text-gray-800
                                    dark:text-gray-100

                                    truncate
                                "
                            >

                                {{ $header }}

                            </div>

                        @else

                            <h1
                                class="
                                    text-lg
                                    sm:text-xl
                                    lg:text-2xl

                                    font-semibold

                                    text-gray-800
                                    dark:text-gray-100

                                    truncate
                                "
                            >
                                Tableau de bord
                            </h1>

                        @endisset

                    </div>


                    <!-- =========================================
                         RECHERCHE DESKTOP

                         Visible uniquement à partir de lg
                    ========================================== -->

                    <div
                        class="
                            hidden
                            lg:block

                            absolute

                            top-1/2
                            left-1/2

                            -translate-x-1/2
                            -translate-y-1/2

                            w-[320px]
                            xl:w-[420px]
                        "
                    >

                        <div class="relative w-full">


                            <!-- Icône recherche -->

                            <div
                                class="
                                    absolute
                                    inset-y-0
                                    left-0

                                    flex
                                    items-center

                                    pl-3

                                    pointer-events-none
                                "
                            >

                                <svg
                                    class="
                                        w-5
                                        h-5

                                        text-gray-400
                                    "

                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"

                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"

                                        d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                                    />

                                </svg>

                            </div>


                            <!-- Champ recherche -->

                            <input
                                type="search"

                                name="search"

                                value="{{ request('search') }}"

                                placeholder="Rechercher..."

                                autocomplete="off"

                                class="
                                    w-full
                                    h-10

                                    pl-10
                                    pr-4

                                    rounded-xl

                                    border
                                    border-gray-300
                                    dark:border-gray-600

                                    bg-gray-50
                                    dark:bg-gray-700

                                    text-sm

                                    text-gray-800
                                    dark:text-white

                                    placeholder-gray-400

                                    outline-none

                                    focus:bg-white
                                    dark:focus:bg-gray-600

                                    focus:border-blue-500

                                    focus:ring-2
                                    focus:ring-blue-500/20

                                    transition
                                "
                            />

                        </div>

                    </div>


                    <!-- =========================================
                         ACTIONS À DROITE
                    ========================================== -->

                    <div
                        class="
                            flex
                            items-center

                            gap-2
                            sm:gap-3

                            flex-shrink-0
                        "
                    >


                        <!-- =====================================
                             NOTIFICATIONS
                        ====================================== -->

                        <button
                            type="button"

                            class="
                                w-10
                                h-10

                                flex
                                items-center
                                justify-center

                                rounded-xl

                                bg-gray-100
                                dark:bg-gray-700

                                text-gray-600
                                dark:text-gray-200

                                hover:bg-gray-200
                                dark:hover:bg-gray-600

                                active:scale-95

                                transition
                            "

                            aria-label="Notifications"
                        >

                            <svg
                                class="w-5 h-5"

                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"

                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"

                                    d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"

                                    d="M9 21h6"
                                />

                            </svg>

                        </button>


                        <!-- =====================================
                             AVATAR UTILISATEUR
                             (cliquable : accès au profil)
                        ====================================== -->

                        @auth

                            <div
                                x-data="{ open: false }"
                                class="relative"
                            >

                                <button
                                    type="button"
                                    @click="open = !open"
                                    class="
                                        w-10
                                        h-10

                                        flex
                                        items-center
                                        justify-center

                                        rounded-full

                                        bg-blue-600

                                        text-white

                                        font-bold

                                        uppercase

                                        hover:ring-2
                                        hover:ring-blue-300

                                        focus:outline-none
                                        focus:ring-2
                                        focus:ring-blue-400

                                        transition
                                    "
                                >

                                    {{ strtoupper(
                                        substr(
                                            $user->name,
                                            0,
                                            1
                                        )
                                    ) }}

                                </button>


                                <div
                                    x-show="open"
                                    x-transition
                                    @click.away="open = false"
                                    class="
                                        absolute

                                        right-0
                                        mt-2

                                        w-48

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

                                    <div
                                        class="
                                            px-4
                                            py-3

                                            border-b
                                            border-gray-100
                                            dark:border-gray-700

                                            text-sm

                                            text-gray-700
                                            dark:text-gray-200

                                            truncate
                                        "
                                    >
                                        {{ $user->name }}
                                    </div>

                                    <a
                                        href="{{ route('profile.edit') }}"
                                        class="
                                            block

                                            px-4
                                            py-2.5

                                            text-sm

                                            text-gray-700
                                            dark:text-gray-200

                                            hover:bg-gray-100
                                            dark:hover:bg-gray-700

                                            transition
                                        "
                                    >
                                        Profil
                                    </a>

                                </div>

                            </div>

                        @endauth

                    </div>

                </div>


                <!-- =================================================
                     RECHERCHE MOBILE / TABLETTE

                     IMPORTANT :
                     Cette partie est la deuxième ligne.

                     lg:hidden =
                     cachée sur ordinateur
                     visible téléphone + tablette
                ================================================== -->

                <div
                    class="
                        lg:hidden

                        w-full

                        px-4
                        sm:px-6

                        pb-4
                    "
                >

                    <div class="relative w-full">


                        <!-- =====================================
                             ICÔNE RECHERCHE
                        ====================================== -->

                        <div
                            class="
                                absolute
                                inset-y-0
                                left-0

                                flex
                                items-center

                                pl-3

                                pointer-events-none
                            "
                        >

                            <svg
                                class="
                                    w-5
                                    h-5

                                    text-gray-400
                                "

                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"

                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"

                                    d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                                />

                            </svg>

                        </div>


                        <!-- =====================================
                             CHAMP RECHERCHE MOBILE
                        ====================================== -->

                        <input
                            type="search"

                            name="search"

                            value="{{ request('search') }}"

                            placeholder="Rechercher..."

                            autocomplete="off"

                            class="
                                block

                                w-full

                                h-11
                                sm:h-12

                                pl-10
                                pr-4

                                rounded-xl

                                border
                                border-gray-300
                                dark:border-gray-600

                                bg-gray-50
                                dark:bg-gray-700

                                text-sm
                                sm:text-base

                                text-gray-800
                                dark:text-white

                                placeholder-gray-400

                                outline-none

                                focus:bg-white
                                dark:focus:bg-gray-600

                                focus:border-blue-500

                                focus:ring-2
                                focus:ring-blue-500/20

                                transition
                            "
                        />

                    </div>

                </div>

            </header>


            <!-- =====================================================
                 CONTENU DE LA PAGE
            ====================================================== -->

            <main
                class="
                    w-full
                    min-w-0

                    p-3
                    sm:p-4
                    lg:p-6
                "
            >

                @yield('content')

            </main>


        </div>

    </div>


</body>

</html>