<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

        $user = Auth::user();

        // Definir el umbral de actividad reciente (basado en la vida de la sesión configurada)
        $lifetimeMinutes = config('session.lifetime', 15);
        $threshold = now()->subMinutes($lifetimeMinutes)->timestamp;

        // Verificar si existe OTRA sesión realmente activa y reciente en otro dispositivo/pestaña
        $existingSession = \DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', $request->session()->getId())
            ->where('last_activity', '>=', $threshold)
            ->first();

        if ($existingSession) {
            // Guardamos temporalmente el ID y redirigimos a la vista de advertencia de doble sesión
            session(['active_session_warning' => $user->id]);
            Auth::logout();
            return redirect()->route('session.warning');
        }

        $request->session()->regenerate();

        // 🛡️ Redirección inteligente según el rol del usuario (forzando la ruta directa)
        if ($user->role === 'admin') {
            return redirect()->route('admin.games.index');
        }

        // Si es cliente normal, lo mandamos al catálogo de la tienda
        return redirect()->intended(route('games.index', absolute: false));
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

    public function closeOtherSessions(Request $request): RedirectResponse
    {
        $userId = session('active_session_warning');

        if (!$userId) {
            return redirect()->route('login');
        }

        // Eliminar las sesiones anteriores del usuario en la base de datos
        \DB::table('sessions')->where('user_id', $userId)->delete();

        // Autenticar al usuario y limpiar la variable temporal
        Auth::loginUsingId($userId);
        $request->session()->forget('active_session_warning');
        $request->session()->regenerate();

        // 🛡️ Redirección inteligente según el rol tras cerrar otras sesiones
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            return redirect()->intended(route('admin.games.index', absolute: false));
        }

        return redirect()->intended(route('games.index', absolute: false));
    }
}