<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanCreateUsers
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verificar si hay un usuario autenticado
        $user = $request->user();

        // 2. Definir los roles autorizados para crear usuarios
        $allowedRoles = [
            'Coordinador Académico',
            'Coordinador Administrativo',
        ];

        // 3. Si no está logueado o su rol no está en la lista permitida, denegar el acceso
        if (! $user || ! in_array($user->role, $allowedRoles)) {
            abort(403, 'No tienes permisos de coordinador para registrar o crear nuevos usuarios.');
        }

        return $next($request);
    }
}
