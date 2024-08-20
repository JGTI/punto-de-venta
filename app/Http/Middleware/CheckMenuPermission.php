<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckMenuPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Obtener la ruta actual
        $currentRoute = $request->route()->getName();

        // Extraer la parte principal de la ruta, eliminando el sufijo (.index, .destroy, etc.)
        $baseRoute = explode('.', $currentRoute)[0];

        // Verificar si el usuario tiene acceso a la ruta base en la tabla de menús
        $hasPermission = DB::table('menus')
            ->where('roles', 'like', '%"'.$user->role_id.'"%')
            ->where(function($query) use ($currentRoute, $baseRoute) {
                $query->where('route', $currentRoute)
                      ->orWhere('route', $baseRoute);
            })
            ->exists();

        if (!$hasPermission or $user->role_id==5 or $user->active!=1) {
            // Redirigir al dashboard si no tiene permiso
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
