<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Auth;

class CheckUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión.');
        }

        // Buscar permisos del usuario
        $permission = UserPermission::findByEmail($user->email);

        if (!$permission) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'No tiene autorización para acceder al sistema de presupuesto. Contacte al administrador.');
        }

        // Guardar permisos en la sesión para uso posterior
        session(['user_permissions' => $permission]);

        // Si el usuario tiene acceso solo a secciones, bloquear acceso a vistas no permitidas
        if ($permission->access_type === 'secciones') {
            // Bloquear Dashboard
            if ($request->is('dashboard*')) {
                return redirect()->route('secciones.index')
                    ->with('info', 'Ha sido redirigido a la vista de secciones según sus permisos.');
            }
            
            // Bloquear Detallado Secciones
            if ($request->is('secciones/detallado*')) {
                return redirect()->route('secciones.index')
                    ->with('info', 'No tiene permiso para acceder a esta vista.');
            }
            
            // Bloquear Secciones Operativas
            if ($request->is('secciones/ib*') || 
                $request->is('secciones/equipo-dotacion-salones*') ||
                $request->is('secciones/aseo-cafeteria*') ||
                $request->is('secciones/dotaciones*') ||
                $request->is('secciones/agasajos*') ||
                $request->is('secciones/tecnologia*') ||
                $request->is('secciones/gastos-contratacion*') ||
                $request->is('secciones/afiliaciones-suscripciones*') ||
                $request->is('secciones/deportes*') ||
                $request->is('secciones/entrenamientos*') ||
                $request->is('secciones/servicios-publicos*') ||
                $request->is('secciones/reparaciones-mayores*') ||
                $request->is('secciones/reparacion-muebles*') ||
                $request->is('secciones/mercadeo*') ||
                $request->is('secciones/honorarios*')) {
                return redirect()->route('secciones.index')
                    ->with('info', 'No tiene permiso para acceder a esta sección operativa.');
            }
            
            // Bloquear Configuraciones
            if ($request->is('import*') || 
                $request->is('presupuesto-secciones*') ||
                $request->is('centro-costo-secciones*')) {
                return redirect()->route('secciones.index')
                    ->with('info', 'No tiene permiso para acceder a las configuraciones.');
            }
        }

        return $next($request);
    }
}
