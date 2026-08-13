<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="KorNet Logo" class="h-28 w-28 rounded-full shadow-lg" />
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Connexion à KorNet</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Entrez vos identifiants pour accéder à votre compte</p>
            </div>

            <div class="bg-white dark:bg-gray-800 py-8 px-6 shadow rounded-lg">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-3">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adresse e-mail</label>
                        <input id="email" name="email" type="email" autocomplete="username" required value="{{ old('email') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>
                    <div class="space-y-3">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mot de passe</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <label class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Se souvenir de moi</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                        @endif
                    </div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-4">
                        Connexion
                    </button>
                </form>

                @php
                    $superAdminExists = \App\Models\User::where('is_super_admin', true)->exists();
                @endphp
                @if (Route::has('register') && !$superAdminExists)
                    <div class="mt-6 text-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Vous n'avez pas de compte ?</span>
                        <a class="ms-1 underline text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800" href="{{ route('register') }}">Inscription</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
