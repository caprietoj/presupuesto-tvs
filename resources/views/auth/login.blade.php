<x-guest-layout>
    @if (session('status'))
        <div class="status-message">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="usuario@tvs.edu.co">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input 
                id="password" 
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="••••••••">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="checkbox-group">
            <label class="checkbox-wrapper">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember">
                <span class="checkbox-label">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-login">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Iniciar Sesión
        </button>
    </form>
</x-guest-layout>
