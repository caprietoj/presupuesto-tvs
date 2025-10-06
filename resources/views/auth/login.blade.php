<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <x-input-label for="email" :value="__('Correo Electrónico')" class="text-sm font-semibold" style="color: #233e6c;" />
        <x-text-input 
            id="email" 
            class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-150" 
            style="focus:ring-color: #233e6c;"
            type="email" 
            name="email" 
            :value="old('email')" 
            required 
            autofocus 
            autocomplete="username"
            placeholder="usuario@tvs.edu.co" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />

        <!-- Password -->
        <x-input-label for="password" :value="__('Contraseña')" class="text-sm font-semibold" style="color: #233e6c;" />
        <x-text-input 
            id="password" 
            class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-150"
            style="focus:ring-color: #233e6c;"
            type="password"
            name="password"
            required 
            autocomplete="current-password"
            placeholder="••••••••" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="rounded border-gray-300 shadow-sm transition duration-150" 
                    style="color: #233e6c; focus:ring-color: #233e6c;"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a 
                    class="text-sm font-medium hover:underline transition duration-150" 
                    style="color: #233e6c;"
                    href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <button 
            type="submit" 
            class="btn-login w-full px-4 py-3 text-white font-semibold rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-opacity-50">
            <span class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                {{ __('Iniciar Sesión') }}
            </span>
        </button>
    </form>
</x-guest-layout>
