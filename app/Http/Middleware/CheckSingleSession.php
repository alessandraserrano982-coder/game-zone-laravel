<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class CheckSingleSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $session = DB::table('sessions')
                ->where('user_id', Auth::id())
                ->where('id', $request->session()->getId())
                ->first();

            if (!$session) {
                $user = Auth::user();
                if ($user) {
                    // 1. Limpiar el token de recuerdo en la base de datos
                    $user->setRememberToken(null);
                    $user->save();
                }

                // 2. Cerrar sesión completamente
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // 3. Obtener el nombre exacto de la cookie de recuerdo de Laravel
                $rememberCookie = Auth::guard()->getRecallerName();

                // 4. Redirigir a sesión expirada olvidando sesión y cookie de recuerdo
                return redirect()->route('session.expired')
                    ->withCookie(Cookie::forget(config('session.cookie')))
                    ->withCookie(Cookie::forget($rememberCookie));
            }
        }

        return $next($request);
    }
}