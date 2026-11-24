<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LibraryController;

// ==========================================
// 1. RUTA PÚBLICA PRINCIPAL (CATÁLOGO ABIERTO)
// ==========================================
// Ahora el catálogo se muestra de entrada en la raíz del sitio para cualquier visitante
Route::get('/', [GameController::class, 'index'])->name('games.index');

// Si por alguna razón quieres mantener la vista de juegos también en /games
Route::resource('games', GameController::class)->only(['index', 'show']);

// ==========================================
// 2. RUTAS PROTEGIDAS (Requieren Iniciar Sesión / Compra / Biblioteca)
// ==========================================
Route::middleware(['auth', 'verified', 'auth.session'])->group(function () {
    
    // Rutas del Carrito
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Rutas para la Biblioteca del usuario
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');

    // Rutas del perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// 3. RUTAS DE AUTENTICACIÓN Y GESTIÓN DE SESIÓN
// ==========================================
require __DIR__.'/auth.php';

// Ruta para mostrar la vista de advertencia de sesión activa
Route::get('/session-warning', function () {
    return view('auth.session-warning');
})->name('session.warning');

// Ruta para procesar el cierre de las demás sesiones y permitir el ingreso
Route::post('/session-close-others', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'closeOtherSessions'])
    ->name('session.close.others');

// Ruta para mostrar la vista de sesión expirada por inactividad (con destrucción total de sesión)
Route::get('/session-expired', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()
        ->view('auth.session-expired')
        ->withCookie(\Cookie::forget(config('session.cookie')))
        ->withCookie(\Cookie::forget(\Illuminate\Support\Facades\Auth::guard()->getRecallerName()));
})->name('session.expired');

    
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Nota: Aquí se maneja el CRUD completo de administración (create, store, edit, update, destroy)
    Route::resource('games', GameController::class);
});