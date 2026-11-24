<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - GAME ZONE</title>
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">
    <meta name="theme-color" content="#0b0614">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0b0614] text-gray-100 font-sans antialiased min-h-screen flex flex-col justify-between"
      x-data="{
          previewOpen: false,
          previewGame: null,
          openPreview(game) {
              this.previewGame = game;
              this.previewOpen = true;
          },
          getEmbedUrl(url) {
              if (!url) return null;
              const match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([A-Za-z0-9_-]{6,})/i);
              return match ? 'https://www.youtube.com/embed/' + match[1] : null;
          }
      }"
      @keydown.escape.window="previewOpen = false">

    <!-- Navbar del Administrador con Logo Neón Estilizado -->
    <header class="w-full border-b border-purple-500/30 bg-[#130b24]/95 backdrop-blur-md sticky top-0 z-40 px-4 sm:px-8 py-3 sm:py-0 sm:h-20 flex flex-wrap items-center justify-between gap-2">
        <div class="flex items-center gap-2.5">
            <span class="w-2.5 h-2.5 rounded-full bg-rose-500 shadow-[0_0_10px_#f43f5e] animate-pulse shrink-0"></span>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.games.index') }}" class="font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 tracking-widest text-base sm:text-lg uppercase">
                    GAME ZONE
                </a>
                <span class="text-[9px] sm:text-[10px] uppercase bg-purple-950/80 px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-md border border-purple-500/40 text-purple-300 font-mono tracking-wider">
                    Admin 🛡️
                </span>
            </div>
        </div>
        
        <div class="flex items-center gap-2 sm:gap-4">
            <a href="{{ route('games.index') }}" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs font-semibold bg-gray-800/80 hover:bg-gray-700 text-gray-300 border border-gray-700 transition-all">
                <span class="hidden sm:inline">Ver Tienda Pública 🌐</span>
                <span class="sm:hidden">Tienda 🌐</span>
            </a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs font-semibold bg-rose-950/60 hover:bg-rose-900/60 text-rose-300 border border-rose-500/40 transition-all">
                    <span class="hidden sm:inline">Cerrar Sesión 🚪</span>
                    <span class="sm:hidden">Salir 🚪</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Contenido Principal del Panel -->
    <main class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-10 w-full flex-1">
        
        <!-- Cabecera de Sección -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6 sm:mb-8 pb-5 sm:pb-6 border-b border-purple-500/20">
            <div>
                <h1 class="text-2xl sm:text-4xl font-black uppercase tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 drop-shadow-[0_0_15px_rgba(168,85,247,0.4)]">
                    Gestión del Catálogo
                </h1>
                <p class="text-xs text-gray-400 mt-1 font-mono">Administra, edita, previsualiza o añade nuevos videojuegos al sistema central.</p>
            </div>

            <!-- Botón para Agregar Nuevo Juego -->
            <a href="{{ route('admin.games.create') }}" class="w-full md:w-auto justify-center px-5 sm:px-6 py-3 rounded-xl font-bold text-white bg-gradient-to-r from-purple-600 to-cyan-600 hover:from-purple-500 hover:to-cyan-500 transition-all shadow-[0_0_20px_rgba(147,51,234,0.4)] text-xs flex items-center gap-2">
                <span>➕ Agregar Nuevo Juego</span>
            </a>
        </div>

        <!-- Alerta de éxito si existe -->
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-xs shadow-[0_0_15px_rgba(16,185,129,0.2)] font-mono">
                ✨ {{ session('success') }}
            </div>
        @endif

        <!-- VISTA MÓVIL (< md): Tarjetas compactas y limpias -->
        <div class="md:hidden space-y-3">
            @forelse ($games as $game)
                <div class="bg-[#130b24] border border-purple-500/30 rounded-2xl p-4 shadow-xl space-y-3 text-xs">
                    <div class="flex items-start gap-3">
                        @if($game->image)
                            <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-14 h-14 rounded-xl object-cover border border-purple-500/30 shrink-0">
                        @else
                            <div class="w-14 h-14 rounded-xl bg-[#0b0614] border border-purple-500/20 flex items-center justify-center text-[10px] text-gray-500 shrink-0">
                                Sin img
                            </div>
                        @endif

                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <span class="font-mono text-[10px] text-purple-400">#{{ $game->id }}</span>
                                @if((int) $game->status === 1)
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-950/70 text-emerald-300 border border-emerald-500/30 text-[10px] font-bold">
                                        ACTIVO
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-rose-950/70 text-rose-300 border border-rose-500/30 text-[10px] font-bold">
                                        INACTIVO
                                    </span>
                                @endif
                            </div>

                            <h3 class="font-bold text-sm text-white truncate mt-0.5">{{ $game->title }}</h3>

                            <div class="flex items-center justify-between gap-2 mt-1">
                                <span class="text-cyan-300 text-[10px] font-mono truncate">{{ $game->genre ?? 'Sin género' }}</span>
                                <span class="font-bold text-emerald-400 shrink-0">${{ number_format($game->price, 2) }} MXN</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pt-2 border-t border-purple-900/40 text-[11px]">
                        <button type="button"
                                @click='openPreview(@json($game))'
                                class="py-2 px-2 rounded-xl font-medium bg-purple-950/70 hover:bg-purple-900/70 text-purple-200 border border-purple-500/30 transition text-center">
                            👁️ Vista
                        </button>

                        <a href="{{ route('admin.games.edit', $game->id) }}"
                           class="py-2 px-2 rounded-xl font-medium bg-cyan-950/60 hover:bg-cyan-900/60 text-cyan-300 border border-cyan-500/30 transition text-center">
                            ✏️ Editar
                        </a>

                        <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este videojuego del catálogo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-2 px-2 rounded-xl font-medium bg-rose-950/60 hover:bg-rose-900/60 text-rose-300 border border-rose-500/30 transition text-center">
                                🗑️ Borrar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-8 px-4 text-center text-gray-500 font-mono text-xs bg-[#130b24] border border-purple-500/20 rounded-2xl">
                    No hay videojuegos registrados en el sistema. ¡Empieza agregando uno nuevo!
                </div>
            @endforelse
        </div>

        <!-- VISTA TABLET / ESCRITORIO (>= md): Tabla completa -->
        <div class="hidden md:block bg-[#130b24]/70 border border-purple-500/30 rounded-2xl overflow-hidden shadow-[0_0_25px_rgba(147,51,234,0.15)] backdrop-blur-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-purple-500/20 bg-purple-950/40 text-purple-300 uppercase tracking-wider font-semibold">
                            <th class="py-4 px-5">ID</th>
                            <th class="py-4 px-5">Videojuego</th>
                            <th class="py-4 px-5">Género</th>
                            <th class="py-4 px-5">Precio</th>
                            <th class="py-4 px-5">Estado</th>
                            <th class="py-4 px-5 text-center">Acciones de Gestión</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-900/30 text-gray-300">
                        @forelse ($games as $game)
                            <tr class="hover:bg-purple-900/15 transition-colors">
                                <td class="py-4 px-5 font-mono text-purple-400">#{{ $game->id }}</td>
                                <td class="py-4 px-5 font-bold text-white">
                                    <div class="flex items-center gap-3">
                                        @if($game->image)
                                            <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-12 h-12 rounded-lg object-cover border border-purple-500/30 shrink-0">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-[#0b0614] border border-purple-500/20 flex items-center justify-center text-[10px] text-gray-500 shrink-0">
                                                Sin img
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-white font-bold">{{ $game->title }}</div>
                                            <div class="text-[11px] text-gray-400 font-normal line-clamp-1 max-w-xs">{{ $game->description }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-5">
                                    @if($game->genre)
                                        <span class="px-2.5 py-1 rounded-md bg-cyan-950/60 text-cyan-300 border border-cyan-500/30 text-[11px] font-semibold">
                                            {{ $game->genre }}
                                        </span>
                                    @else
                                        <span class="text-gray-500 italic text-[11px]">Sin asignar</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 font-semibold text-emerald-400 whitespace-nowrap">${{ number_format($game->price, 2) }} MXN</td>
                                <td class="py-4 px-5 whitespace-nowrap">
                                    @if((int) $game->status === 1)
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-950/70 text-emerald-300 border border-emerald-500/30 text-[10px] font-bold">
                                            ACTIVO
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full bg-rose-950/70 text-rose-300 border border-rose-500/30 text-[10px] font-bold">
                                            INACTIVO
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-center whitespace-nowrap space-x-1.5">
                                    <!-- Botón Vista Previa Rápida -->
                                    <button type="button"
                                            @click='openPreview(@json($game))'
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg font-medium bg-purple-950/70 hover:bg-purple-900/70 text-purple-200 border border-purple-500/30 transition-all">
                                        👁️ Vista
                                    </button>

                                    <!-- Botón Editar -->
                                    <a href="{{ route('admin.games.edit', $game->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg font-medium bg-cyan-950/60 hover:bg-cyan-900/60 text-cyan-300 border border-cyan-500/30 transition-all">
                                        ✏️ Editar
                                    </a>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este videojuego del catálogo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg font-medium bg-rose-950/60 hover:bg-rose-900/60 text-rose-300 border border-rose-500/30 transition-all">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500 font-mono">
                                    No hay videojuegos registrados en el sistema. ¡Empieza agregando uno nuevo!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- ========================================================= -->
    <!-- MODAL DE VISTA PREVIA RÁPIDA PARA EL ADMINISTRADOR        -->
    <!-- ========================================================= -->
    <div x-show="previewOpen"
         x-transition
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4"
         @click.self="previewOpen = false">
        <div x-show="previewGame !== null" class="max-w-4xl w-full max-h-[90vh] overflow-y-auto rounded-2xl bg-[#130b24] border border-purple-500/40 shadow-[0_0_40px_rgba(147,51,234,0.35)] p-5 sm:p-6 space-y-6 text-xs">
            <div class="flex items-start justify-between gap-4 border-b border-purple-500/20 pb-4">
                <div>
                    <span class="text-[10px] font-mono uppercase px-2.5 py-1 rounded-md bg-cyan-950/70 text-cyan-300 border border-cyan-500/30"
                          x-text="previewGame && previewGame.genre ? previewGame.genre : 'Sin género'"></span>
                    <h2 class="text-xl sm:text-2xl font-black text-white uppercase mt-2" x-text="previewGame ? previewGame.title : ''"></h2>
                </div>
                <button type="button"
                        @click="previewOpen = false"
                        class="px-3 py-1.5 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-200 font-semibold shrink-0">
                    ✕ Cerrar
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-3">
                    <div class="aspect-video rounded-xl overflow-hidden bg-[#0b0614] border border-purple-500/30 flex items-center justify-center">
                        <template x-if="previewGame && getEmbedUrl(previewGame.trailer_url)">
                            <iframe :src="getEmbedUrl(previewGame.trailer_url)"
                                    class="w-full h-full"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </template>
                        <template x-if="previewGame && !getEmbedUrl(previewGame.trailer_url) && previewGame.image">
                            <img :src="previewGame.image" :alt="previewGame.title" class="w-full h-full object-cover">
                        </template>
                        <template x-if="previewGame && !getEmbedUrl(previewGame.trailer_url) && !previewGame.image">
                            <span class="text-gray-500">Sin tráiler ni portada</span>
                        </template>
                    </div>
                </div>

                <div class="rounded-xl bg-[#0b0614] border border-purple-500/30 p-4 space-y-3">
                    <img x-show="previewGame && previewGame.image" :src="previewGame ? previewGame.image : ''" :alt="previewGame ? previewGame.title : ''"
                         class="w-full h-32 object-cover rounded-lg border border-purple-500/20">

                    <div class="flex justify-between gap-2">
                        <span class="text-gray-400">Precio:</span>
                        <span class="text-cyan-400 font-black text-sm" x-text="previewGame ? '$' + Number(previewGame.price || 0).toFixed(2) + ' MXN' : ''"></span>
                    </div>
                    <div class="flex justify-between gap-2">
                        <span class="text-gray-400">Lanzamiento:</span>
                        <span class="text-white font-semibold" x-text="previewGame && previewGame.release_date ? previewGame.release_date : 'No definido'"></span>
                    </div>
                    <div class="flex justify-between gap-2">
                        <span class="text-gray-400">Desarrollador:</span>
                        <span class="text-cyan-300 font-semibold text-right" x-text="previewGame && previewGame.developer ? previewGame.developer : 'No definido'"></span>
                    </div>
                    <div class="flex justify-between gap-2">
                        <span class="text-gray-400">Distribuidora:</span>
                        <span class="text-purple-300 font-semibold text-right" x-text="previewGame && previewGame.publisher ? previewGame.publisher : 'No definido'"></span>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-[#0b0614] border border-purple-500/20 p-4">
                <h3 class="font-bold text-cyan-400 uppercase mb-1.5">Descripción</h3>
                <p class="text-gray-300 whitespace-pre-line leading-relaxed" x-text="previewGame ? previewGame.description : ''"></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="rounded-xl bg-[#0b0614] border border-purple-500/20 p-4">
                    <h3 class="font-bold text-cyan-400 uppercase mb-1.5">Requisitos Mínimos</h3>
                    <p class="text-gray-300 whitespace-pre-line leading-relaxed" x-text="previewGame && previewGame.minimum_requirements ? previewGame.minimum_requirements : 'No especificados.'"></p>
                </div>
                <div class="rounded-xl bg-[#0b0614] border border-purple-500/20 p-4">
                    <h3 class="font-bold text-purple-300 uppercase mb-1.5">Requisitos Recomendados</h3>
                    <p class="text-gray-300 whitespace-pre-line leading-relaxed" x-text="previewGame && previewGame.recommended_requirements ? previewGame.recommended_requirements : 'No especificados.'"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full border-t border-purple-500/20 py-6 text-center text-xs text-gray-500 bg-[#08040f] font-mono">
        &copy; 2026 GAME ZONE - Sistema de Administración Central. Todos los derechos reservados.
    </footer>

</body>
    <script>
        let inactivityTimeout = 900000;
        let logoutTimer;

        function resetTimer() {
            clearTimeout(logoutTimer);
            logoutTimer = setTimeout(() => {
                window.location.href = "{{ route('session.expired') }}";
            }, inactivityTimeout);
        }

        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onkeypress = resetTimer;
        window.onclick = resetTimer;
        window.onscroll = resetTimer;
    </script>
</html> 