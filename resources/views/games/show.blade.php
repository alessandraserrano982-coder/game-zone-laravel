<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $game->title }} - GAME ZONE</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0b0614] text-gray-100 font-sans antialiased min-h-screen">

    @php
        $embedUrl = null;
        if (!empty($game->trailer_url)) {
            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([A-Za-z0-9_-]{6,})/i', $game->trailer_url, $matches)) {
                $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
            }
        }
    @endphp

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Barra superior de regreso -->
        <div class="flex items-center justify-between gap-4 mb-6">
            <a href="{{ route('games.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#130b24] hover:bg-[#1c1036] border border-purple-500/40 text-purple-200 hover:text-cyan-300 text-xs font-semibold transition">
                <span>← Volver al catálogo</span>
            </a>

            @auth
                <button type="button"
                        @click="$dispatch('open-cart')"
                        class="px-4 py-2 rounded-xl bg-[#130b24] hover:bg-[#1c1036] border border-cyan-500/40 text-cyan-300 text-xs font-bold tracking-wider transition">
                    🛒 VER CARRITO
                </button>
            @endauth
        </div>

        <!-- Título principal -->
        <div class="mb-6">
            <h1 class="text-2xl sm:text-4xl font-black text-white tracking-wide uppercase">
                {{ $game->title }}
            </h1>
        </div>

        <!-- Bloque principal estilo Steam: Media / Tráiler + Ficha y Compra -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Columna izquierda: Tráiler o Portada -->
            <div class="lg:col-span-2 space-y-4">
                <div class="rounded-2xl overflow-hidden bg-[#130b24] border border-purple-500/40 shadow-[0_0_30px_rgba(147,51,234,0.2)] aspect-video flex items-center justify-center">
                    @if ($embedUrl)
                        <iframe
                            src="{{ $embedUrl }}"
                            title="Tráiler de {{ $game->title }}"
                            class="w-full h-full"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    @elseif (!empty($game->image))
                        <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-400 text-sm">Sin vista previa disponible</span>
                    @endif
                </div>

                @if (!empty($game->trailer_url))
                    <div class="flex justify-end">
                        <a href="{{ $game->trailer_url }}" target="_blank" rel="noopener noreferrer"
                           class="text-xs text-cyan-400 hover:text-cyan-300 underline">
                            Abrir tráiler en pestaña nueva ↗
                        </a>
                    </div>
                @endif
            </div>

            <!-- Columna derecha: Portada miniatura, metadatos y compra -->
            <div class="rounded-2xl bg-[#130b24]/95 border border-purple-500/40 p-5 flex flex-col justify-between shadow-[0_0_25px_rgba(147,51,234,0.2)]">
                <div class="space-y-4">
                    @if (!empty($game->image))
                        <img src="{{ $game->image }}" alt="Portada de {{ $game->title }}"
                             class="w-full h-44 object-cover rounded-xl border border-purple-500/30">
                    @endif

                    <div class="space-y-2 text-xs border-t border-b border-purple-500/20 py-4">
                        <div class="flex justify-between gap-2">
                            <span class="text-gray-400">Género:</span>
                            <span class="text-cyan-300 font-semibold text-right">{{ $game->genre ?: 'No especificado' }}</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-gray-400">Lanzamiento:</span>
                            <span class="text-white font-semibold">
                                {{ $game->release_date ? \Carbon\Carbon::parse($game->release_date)->format('d/m/Y') : 'Por confirmar' }}
                            </span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-gray-400">Desarrollador:</span>
                            <span class="text-cyan-300 font-semibold text-right">{{ $game->developer ?: 'No especificado' }}</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-gray-400">Distribuidora:</span>
                            <span class="text-purple-300 font-semibold text-right">{{ $game->publisher ?: 'No especificado' }}</span>
                        </div>
                    </div>

                    <!-- Caja de compra -->
                    <div class="p-4 rounded-xl bg-[#0b0614] border border-cyan-500/30 space-y-3">
                        <div class="flex items-baseline justify-between">
                            <span class="text-xs text-gray-400 uppercase font-semibold">Precio</span>
                            <span class="text-2xl font-black text-cyan-400">
                                ${{ number_format((float) $game->price, 2) }} <span class="text-xs font-normal text-gray-300">MXN</span>
                            </span>
                        </div>

                        @auth
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="game_id" value="{{ $game->id }}">
                                <button type="submit"
                                        class="w-full py-3 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-500 hover:to-cyan-400 text-white font-black text-xs tracking-wider uppercase shadow-[0_0_20px_rgba(6,182,212,0.4)] transition">
                                    Añadir al carrito 🛒
                                </button>
                            </form>
                        @else
                            <a href="{{ route('register') }}"
                               class="block w-full text-center py-3 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-500 hover:to-cyan-400 text-white font-black text-xs tracking-wider uppercase shadow-[0_0_20px_rgba(6,182,212,0.4)] transition">
                                Registrarse para comprar
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Acerca de este juego -->
        <div class="rounded-2xl bg-[#130b24]/95 border border-purple-500/40 p-6 mb-8">
            <h2 class="text-lg font-black text-cyan-400 uppercase tracking-wider mb-3">
                Acerca de este juego
            </h2>
            <p class="text-sm text-gray-200 leading-relaxed whitespace-pre-line">{{ $game->description }}</p>
        </div>

        <!-- Requisitos del sistema -->
        <div class="rounded-2xl bg-[#130b24]/95 border border-purple-500/40 p-6">
            <h2 class="text-lg font-black text-purple-300 uppercase tracking-wider mb-5">
                Requisitos del sistema
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-5 rounded-xl bg-[#0b0614] border border-purple-500/25">
                    <h3 class="text-sm font-bold text-cyan-400 uppercase mb-3">Mínimos</h3>
                    <div class="text-xs text-gray-300 leading-relaxed whitespace-pre-line">
                        {{ $game->minimum_requirements ?: 'No especificados aún.' }}
                    </div>
                </div>

                <div class="p-5 rounded-xl bg-[#0b0614] border border-purple-500/25">
                    <h3 class="text-sm font-bold text-purple-300 uppercase mb-3">Recomendados</h3>
                    <div class="text-xs text-gray-300 leading-relaxed whitespace-pre-line">
                        {{ $game->recommended_requirements ?: 'No especificados aún.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>