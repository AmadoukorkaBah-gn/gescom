<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
            </div>

            <!-- Topbar User/Notif/Search/Settings -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 w-full">
                <!-- Search bar -->
                <form action="{{ route('produits.index') }}" method="GET" class="relative flex-shrink-0 ml-72">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..."
                        class="pl-10 pr-4 py-2 w-96 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-100 dark:bg-gray-700 dark:text-white" />
                    <span class="absolute left-2 top-2.5 text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </span>
                </form>

                <div class="flex-1"></div>

                <div class="flex items-center space-x-2">

                    <!-- Notifications Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="relative p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                            <svg class="h-6 w-6 text-gray-500 dark:text-gray-300" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-red-500"></span>
                        </button>
                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-2 px-4 text-gray-700 dark:text-gray-200 text-sm">
                                <span class="font-semibold">Notifications</span>
                            </div>
                            <div class="max-h-60 overflow-y-auto">
                                @if(!empty($notifications))
                                    @foreach($notifications as $notif)
                                        <div class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">{{ $notif }}</div>
                                    @endforeach
                                @else
                                    <div class="px-4 py-2 text-gray-400">Aucune notification</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Paramètres -->

                    <a href="{{ route('profile.edit') }}"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                        <svg class="h-6 w-6 text-gray-500 dark:text-gray-300" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 007 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 003 15.6V15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 005 7.6a1.65 1.65 0 00.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 5.6V5a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09A1.65 1.65 0 0017 4.6a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9H21a2 2 0 010 4h-.09A1.65 1.65 0 0019.4 15z" />
                        </svg>
                    </a>
                </div>

                @auth
                <div class="flex flex-col items-center ml-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff"
                        alt="Avatar"
                        class="h-9 w-9 rounded-full border-2 border-gray-300 shadow object-cover mb-1">
                    <span class="font-semibold text-gray-700 dark:text-gray-200 text-xs">
                        {{ Auth::user()->name }}
                    </span>
                </div>
                @endauth

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Log Out
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-4 pb-1 border-t">
            @auth
            <div class="px-4">
                <div class="font-medium text-base">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            @endauth
        </div>
    </div>
</nav>
