<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AutologinToken;

class AutologinController extends Controller
{
    /**
     * Generar token de autologin (llamado desde intranet)
     */
    public function generateToken(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'user_email' => 'required|email',
            'secret' => 'required|string',
        ]);

        // Validar secret key (debe coincidir en ambas aplicaciones)
        if ($request->secret !== env('AUTOLOGIN_SECRET', 'change-this-secret-key')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Verificar que el usuario existe en intranet
        $user = DB::connection('intranet')
            ->table('users')
            ->where('id', $request->user_id)
            ->where('email', $request->user_email)
            ->where('active', 1)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Generar token
        $tokenRecord = AutologinToken::generateToken(
            $request->user_id,
            $request->user_email,
            5 // expira en 5 minutos
        );

        return response()->json([
            'success' => true,
            'token' => $tokenRecord->token,
            'url' => route('autologin', ['token' => $tokenRecord->token]),
            'expires_at' => $tokenRecord->expires_at->toISOString(),
        ]);
    }

    /**
     * Autologin con token
     */
    public function autologin(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()->route('login')
                ->with('error', 'Token de autenticación no proporcionado.');
        }

        // Buscar token
        $tokenRecord = AutologinToken::where('token', $token)
            ->valid()
            ->first();

        if (!$tokenRecord) {
            return redirect()->route('login')
                ->with('error', 'Token de autenticación inválido o expirado.');
        }

        // Consumir token
        if (!$tokenRecord->consume()) {
            return redirect()->route('login')
                ->with('error', 'Este token ya fue utilizado.');
        }

        // Obtener usuario de intranet
        $user = DB::connection('intranet')
            ->table('users')
            ->where('id', $tokenRecord->user_id)
            ->where('active', 1)
            ->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Usuario no encontrado o inactivo.');
        }

        // Crear objeto de usuario autenticable
        $authUser = new \App\Auth\IntranetUser((array) $user);

        // Autenticar usuario
        Auth::login($authUser, true); // true = remember me

        // Redirigir al dashboard
        return redirect()->intended(route('dashboard'))
            ->with('success', '¡Bienvenido ' . $user->name . '!');
    }
}
