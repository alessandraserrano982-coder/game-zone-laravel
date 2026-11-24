<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si está autenticado y si su rol es admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Si no es admin, abortamos con un error 403 (Acceso no autorizado)
        abort(403, 'Acceso no autorizado. Zona exclusiva para administradores.');
    }
}