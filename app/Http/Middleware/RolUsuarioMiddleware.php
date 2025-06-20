<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class RolUsuarioMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
 
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $usuario = $request->user();

        if (!$usuario || !$usuario->relationLoaded('role')) {
            $usuario->load('role');
        }

        $rolNombre = $usuario->role->name ?? null;

        if (!$rolNombre || !in_array($rolNombre, $roles)) {
            abort(403, 'No tienes permiso para acceder.');
        }

        return $next($request);
    }
    
}
