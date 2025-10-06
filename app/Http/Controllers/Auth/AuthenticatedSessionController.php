<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\UserPermission;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Obtener permisos del usuario para determinar la ruta de redirección
        $user = Auth::user();
        $permission = UserPermission::findByEmail($user->email);

        // Si el usuario tiene acceso solo a secciones, redirigir a secciones
        // Si tiene acceso total, redirigir al dashboard
        $intendedRoute = ($permission && $permission->access_type === 'secciones') 
            ? route('secciones.index', absolute: false)
            : route('dashboard', absolute: false);

        return redirect()->intended($intendedRoute);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
