<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GAME ZONE - Cyberpunk Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes neon-sweep {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .neon-text-animation {
            background: linear-gradient(90deg, #a855f7, #ffffff, #06b6d4, #a855f7);
            background-size: 200% auto;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            animation: neon-sweep 4s linear infinite;
        }
        @keyframes float-cyber {
            0%, 100% { transform: translateY(0px) scale(1); filter: drop-shadow(0 0 20px rgba(168,85,247,0.5)); }
            50% { transform: translateY(-12px) scale(1.02); filter: drop-shadow(0 0 35px rgba(6,182,212,0.8)); }
        }
        .cyber-image-float {
            animation: float-cyber 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-[#0b0614] text-gray-100 min-h-screen flex flex-col justify-between selection:bg-purple-500 selection:text-white">

    <!-- Navbar Superior -->
    <header class="w-full border-b border-purple-500/20 bg-[#130b24]/60 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-cyan-400 shadow-[0_0_10px_#22d3ee] animate-pulse"></span>
                <span class="font-black text-xl tracking-wider text-white">GAME<span class="text-purple-400">ZONE</span></span>
            </div>
            
            <nav class="flex items-center gap-6 text-sm font-semibold">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/games') }}" class="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white shadow-[0_0_15px_rgba(147,51,234,0.5)] transition-all">Ir al Catálogo</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-purple-400 transition-colors">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-600 hover:from-purple-500 hover:to-cyan-500 text-white shadow-[0_0_15px_rgba(6,182,212,0.4)] transition-all">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Sección Hero Principal -->
    <main class="flex-1 flex items-center justify-center relative overflow-hidden py-12 px-4">
        <!-- Luces de fondo difuminadas -->
        <div class="absolute w-96 h-96 bg-purple-600/20 rounded-full blur-3xl -top-10 -left-10 pointer-events-none"></div>
        <div class="absolute w-96 h-96 bg-cyan-600/15 rounded-full blur-3xl -bottom-10 -right-10 pointer-events-none"></div>

        <div class="max-w-4xl mx-auto text-center space-y-6 relative z-10 flex flex-col items-center">
            
            <!-- Contenedor Círculo Agrandado para el GIF -->
            <div class="w-44 h-44 sm:w-56 sm:h-56 rounded-full overflow-hidden border-2 border-cyan-400/80 shadow-[0_0_40px_rgba(6,182,212,0.5)] bg-[#130b24] cyber-image-float mb-4 flex items-center justify-center">
                <img src="https://giffiles.alphacoders.com/223/223031.gif" alt="Vayne Proyecto GIF" class="w-full h-full object-cover scale-105">
            </div>

            <!-- Título reordenado en dos líneas -->
            <div class="space-y-1">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-widest text-gray-300 uppercase">
                    BIENVENIDO A
                </h2>
                <h1 class="text-5xl sm:text-7xl font-black tracking-wider uppercase neon-text-animation">
                    GAME ZONE
                </h1>
            </div>

            <p class="text-gray-400 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                Adéntrate en el catálogo de videojuegos de alto rendimiento. Explora clásicos de culto, survival horror y mundos virtuales bajo una interfaz protegida y cifrada.
            </p>
        </div>
    </main>

    <!-- Pie de página -->
    <footer class="w-full border-t border-purple-500/20 py-6 text-center text-xs text-gray-500 bg-[#08040f]">
        &copy; 2026 GAME ZONE - Sistema de Entretenimiento Digital. Todos los derechos reservados.
    </footer>

</body>
</html>