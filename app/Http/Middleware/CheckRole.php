<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verifica si el usuario inició sesión y si su rol coincide con el requerido
        if (! $request->user() || $request->user()->role !== $role) {
            abort(403, 'Acceso no autorizado para tu rol.');
        }

        return $next($request);
    }
}