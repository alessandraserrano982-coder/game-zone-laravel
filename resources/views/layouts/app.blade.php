<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>GAME ZONE</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts / Tailwind de Breeze -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Icono para navegador y accesos directos en celular -->
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">
        <meta name="theme-color" content="#0b0614">

        <style>
            body {
                background-color: #0b0614 !important;
                color: #e2d9f3 !important;
            }
            /* Barra de navegación superior */
            nav.bg-white {
                background-color: #120924 !important;
                border-bottom: 2px solid #a855f7 !important;
                box-shadow: 0 0 15px rgba(168, 85, 247, 0.4);
            }
            /* Texto y enlaces del menú superior */
            nav a, nav button {
                color: #d8b4fe !important;
            }
            nav a:hover, nav button:hover {
                color: #22d3ee !important;
                text-shadow: 0 0 8px rgba(34, 211, 238, 0.8);
            }
            /* Cabecera interna del dashboard */
            header.bg-white {
                background-color: #160c2b !important;
                border-bottom: 1px solid #7c3aed !important;
                box-shadow: inset 0 0 15px rgba(124, 58, 237, 0.2);
            }
            header h2 {
                color: #22d3ee !important;
                text-shadow: 0 0 10px rgba(34, 211, 238, 0.6);
                letter-spacing: 1px;
            }
            /* Menú desplegable del usuario */
            .absolute.rounded-md {
                background-color: #160c2b !important;
                border: 1px solid #7c3aed !important;
                box-shadow: 0 0 20px rgba(168, 85, 247, 0.4) !important;
            }
            .absolute.rounded-md a, .absolute.rounded-md button {
                color: #e2d9f3 !important;
            }
            .absolute.rounded-md a:hover, .absolute.rounded-md button:hover {
                background-color: #251647 !important;
                color: #22d3ee !important;
            }

            /* Barra de desplazamiento global personalizada */
            ::-webkit-scrollbar {
                width: 10px;
                height: 10px;
            }
            ::-webkit-scrollbar-track {
                background: #0b0614;
            }
            ::-webkit-scrollbar-thumb {
                background: #9333ea;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(147, 51, 234, 0.5);
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #22d3ee;
                box-shadow: 0 0 15px rgba(34, 211, 238, 0.8);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen" style="background-color: #0b0614;">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            
            <!-- Panel Deslizante del Carrito (Global) -->
            @auth
                @php
                    $globalCartItems = \App\Models\CartItem::where('user_id', Auth::id())->with('game')->get();
                @endphp

                <div x-data="{ cartOpen: false, paymentModal: false }" 
                    @open-cart.window="cartOpen = true" 
                    @toggle-cart.window="cartOpen = !cartOpen" 
                    class="relative z-50">
                    
                    <!-- Fondo oscuro semitransparente -->
                    <div x-show="cartOpen" 
                        x-transition.opacity 
                        class="fixed inset-0 bg-black/70 backdrop-blur-sm" 
                        @click="cartOpen = false" 
                        style="display: none;"></div>

                    <!-- Panel Lateral -->
                    <div x-show="cartOpen" 
                        x-transition:enter="transition transform ease-out duration-300"
                        x-transition:enter-start="translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave="transition transform ease-in duration-300"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full"
                        class="fixed inset-y-0 right-0 max-w-md w-full bg-[#130b24] border-l border-purple-500/40 shadow-[0_0_30px_rgba(0,0,0,0.9)] p-6 flex flex-col justify-between text-gray-100 z-50"
                        style="display: none;">
                        
                        <!-- Cabecera -->
                        <div>
                            <div class="flex items-center justify-between pb-4 border-b border-purple-500/30">
                                <h3 class="text-xl font-black text-cyan-400 uppercase tracking-wider">Carrito de Adquisiciones</h3>
                                <button @click="cartOpen = false" class="text-gray-400 hover:text-red-400 font-mono text-lg">✕</button>
                            </div>

                            <!-- Lista de Juegos en el Carrito -->
                            <div class="mt-6 space-y-4 overflow-y-auto max-h-[60vh] pr-2">
                                @forelse($globalCartItems as $item)
                                    <div class="p-3 rounded-xl bg-[#08040f] border border-purple-500/20 flex items-center justify-between gap-3">
                                        <div>
                                            <h4 class="font-bold text-sm text-white">{{ $item->game->title ?? 'Juego' }}</h4>
                                            <p class="text-xs text-cyan-400 font-mono">Cantidad: {{ $item->quantity }}</p>
                                        </div>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-400 hover:text-red-300 font-mono">Eliminar</button>
                                        </form>
                                    </div>
                                @empty
                                    <p class="text-gray-400 font-mono text-sm text-center py-8">Tu carrito está vacío.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Pie de página y Pago -->
                        <div class="border-t border-purple-500/30 pt-4 space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Total artículos:</span>
                                <span class="font-mono text-cyan-400 font-bold">{{ $globalCartItems->sum('quantity') }}</span>
                            </div>
                            <button @click="paymentModal = true; cartOpen = false;" type="button" class="w-full py-3 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-bold text-sm tracking-wider shadow-[0_0_20px_rgba(6,182,212,0.5)] hover:shadow-[0_0_25px_rgba(147,51,234,0.8)] transition">
                                PROCESAR ADQUISICIÓN
                            </button>
                        </div>
                    </div>

                    <!-- Ventana Emergente (Modal) de Simulación de Pago Validado -->
                    <div x-show="paymentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm" style="display: none;">
                        <div class="bg-[#130b24] border border-purple-500/40 w-full max-w-md p-6 rounded-2xl shadow-2xl text-white relative">
                            
                            <!-- Botón cerrar modal -->
                            <button @click="paymentModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-white font-bold">
                                ✕
                            </button>

                            <h3 class="text-xl font-black text-cyan-400 mb-2 uppercase tracking-wider">Simulación de Pago</h3>
                            <p class="text-xs text-gray-300 mb-6">Ingresa los datos de tu tarjeta para completar la adquisición de tus juegos.</p>

                            <!-- Formulario de pago conectado al checkout con validaciones -->
                            <form action="{{ route('cart.checkout') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Nombre del Titular</label>
                                    <input type="text" name="cardholder_name" required placeholder="Ej. Juan Pérez" value="{{ old('cardholder_name') }}" class="w-full bg-[#1e1438] border border-purple-500/30 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-cyan-400">
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Número de Tarjeta</label>
                                    <input type="text" name="card_number" required placeholder="4000 1234 5678 9010" maxlength="19" value="{{ old('card_number') }}" class="w-full bg-[#1e1438] border border-purple-500/30 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-cyan-400">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-400 mb-1">Expiración (MM/AA)</label>
                                        <input type="text" name="expiration_date" required placeholder="12/28" maxlength="5" value="{{ old('expiration_date') }}" class="w-full bg-[#1e1438] border border-purple-500/30 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-cyan-400">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-400 mb-1">CVV</label>
                                        <input type="password" name="cvv" required placeholder="123" maxlength="4" class="w-full bg-[#1e1438] border border-purple-500/30 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-cyan-400">
                                    </div>
                                </div>

                                <div class="pt-4 flex space-x-3">
                                    <button type="button" @click="paymentModal = false" class="w-1/2 py-2.5 rounded-xl bg-gray-700 hover:bg-gray-600 font-bold text-xs transition">
                                        Cancelar
                                    </button>
                                    <button type="submit" class="w-1/2 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 font-bold text-xs tracking-wider shadow-lg hover:shadow-cyan-500/50 transition">
                                        CONFIRMAR PAGO 💳
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            @endauth
        </div>

        <!-- ========================================================= -->
        <!-- NOTIFICACIONES FLOTANTES (Toast de Éxito / Error)         -->
        <!-- ========================================================= -->
        @if (session('success') || session('error') || session('status'))
            @php
                $statusText = match (session('status')) {
                    'profile-updated' => '¡Tu información de perfil se actualizó correctamente!',
                    'password-updated' => '¡Tu contraseña se actualizó correctamente!',
                    default => null,
                };
                $isError = session()->has('error');
                $message = session('error') ?? session('success') ?? $statusText;
            @endphp

            @if ($message)
                <div id="flash-toast"
                     class="fixed top-5 right-5 z-[60] flex items-center gap-3 px-4 py-3 rounded-xl {{ $isError ? 'bg-[#261018]/95 border-rose-500/50 shadow-[0_0_20px_rgba(244,63,94,0.35)]' : 'bg-[#141026]/95 border-cyan-400/50 shadow-[0_0_20px_rgba(6,182,212,0.35)]' }} border text-white backdrop-blur-md transition-all duration-500">
                    <span class="{{ $isError ? 'text-rose-400' : 'text-cyan-400' }} font-bold text-lg">
                        {{ $isError ? '!' : '✓' }}
                    </span>
                    <p class="text-sm font-medium">{{ $message }}</p>
                    <button type="button"
                            onclick="document.getElementById('flash-toast').remove()"
                            class="ml-2 text-slate-400 hover:text-white text-xs">
                        ✕
                    </button>
                </div>

                <script>
                    setTimeout(() => {
                        const toast = document.getElementById('flash-toast');
                        if (toast) {
                            toast.style.opacity = '0';
                            toast.style.transform = 'translateY(-10px)';
                            setTimeout(() => toast.remove(), 500);
                        }
                    }, 4000);
                </script>
            @endif
        @endif

        <!-- ========================================================= -->
        <!-- SCRIPTS GLOBALES DE SEGURIDAD (Inactividad y Sesión)     -->
        <!-- ========================================================= -->
        <script>
            let inactivityTimeout = 900000; 
            let logoutTimer;

            function resetTimer() {
                clearTimeout(logoutTimer);
                logoutTimer = setTimeout(() => {
                    // Redirigir automáticamente a la vista de sesión expirada cuando pase el tiempo
                    window.location.href = "{{ route('session.expired') }}";
                }, inactivityTimeout);
            }

            // Eventos que detectan actividad del usuario en cualquier página del sistema
            window.onload = resetTimer;
            window.onmousemove = resetTimer;
            window.onkeypress = resetTimer;
            window.onclick = resetTimer;
            window.onscroll = resetTimer;
        </script>

    </body>
</html>