<x-app-layout>
    <!-- Barra de Navegación Superior -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 tracking-widest">
                GAME ZONE
            </h1>
        </div>
    </x-slot>

    <!-- Contenedor Principal con Alpine.js para Filtros y Búsqueda -->
    <div class="py-6 sm:py-8 bg-[#0b0614] min-h-screen text-gray-100"
         x-data="{
             activeFilter: 'all',
             searchQuery: '',
             matchesGame(title, genre) {
                 const matchesGenre = this.activeFilter === 'all' || this.activeFilter === genre;
                 const query = this.searchQuery.trim().toLowerCase();
                 const matchesSearch = !query || String(title || '').toLowerCase().includes(query);
                 return matchesGenre && matchesSearch;
             }
         }">
        <div class="w-full px-3 sm:px-8 lg:px-12 space-y-8 sm:space-y-10">

            <!-- ================================================= -->
            <!-- 1. CARRUSEL / BANNER PRINCIPAL (NOVEDADES)        -->
            <!-- ================================================= -->
            <div class="relative rounded-3xl bg-gradient-to-r from-[#1b1035] via-[#130b24] to-[#0f071a] backdrop-blur-xl border border-purple-500/30 p-4 sm:p-6 shadow-2xl overflow-hidden">
                
                <!-- Efecto visual / Resplandor inspirado en la plantilla cyberpunk -->
                <div class="absolute top-0 right-0 w-96 h-full bg-gradient-to-l from-purple-600/20 via-cyan-500/10 to-transparent blur-2xl pointer-events-none"></div>

                <div class="flex items-center justify-between mb-4 sm:mb-6 relative z-10">
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase text-purple-400 bg-purple-950/80 px-3 py-1 rounded-full border border-purple-500/30">
                            🌟 Destacados y Novedades
                        </span>
                        <h3 class="text-lg sm:text-2xl font-black text-white mt-2 tracking-wide">
                            Últimos Lanzamientos del Sistema
                        </h3>
                    </div>
                </div>

                <div class="flex gap-4 sm:gap-6 overflow-x-auto pb-3 scrollbar-thin scrollbar-thumb-purple-600 scrollbar-track-transparent relative z-10">
                    @foreach($games->take(3) as $featuredGame)
                        <div class="min-w-[260px] sm:min-w-[360px] flex-1 rounded-2xl bg-[#0b0614]/80 border border-purple-900/60 overflow-hidden flex flex-col justify-between shadow-xl hover:border-purple-500/80 transition-all">
                            <a href="{{ route('games.show', $featuredGame->id) }}" class="h-44 sm:h-52 overflow-hidden relative block group">
                                <img src="{{ $featuredGame->image ?? 'https://via.placeholder.com/400x250' }}" alt="{{ $featuredGame->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <span class="absolute top-3 left-3 bg-purple-600 text-white text-[10px] sm:text-[11px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider shadow">
                                    NUEVO
                                </span>
                            </a>
                            <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
                                <div>
                                    <a href="{{ route('games.show', $featuredGame->id) }}" class="hover:text-cyan-400 transition-colors">
                                        <h4 class="font-bold text-white text-base sm:text-lg mb-1 hover:text-cyan-400 transition-colors line-clamp-1">{{ $featuredGame->title }}</h4>
                                    </a>
                                    <p class="text-xs text-gray-400 mb-3 sm:mb-4 line-clamp-1">{{ $featuredGame->description }}</p>
                                </div>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-purple-400 font-extrabold text-sm sm:text-base">${{ number_format($featuredGame->price, 2) }} MXN</span>
                                    
                                    @guest
                                        <a href="{{ route('register') }}" class="px-3 sm:px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-semibold transition-all shadow-md text-center shrink-0">
                                            Comprar 🛒
                                        </a>
                                    @else
                                        @if(in_array($featuredGame->id, $ownedGameIds ?? []))
                                            <a href="{{ route('library.index') }}" class="px-3 sm:px-4 py-2 rounded-xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-300 text-xs font-semibold transition-all text-center shrink-0">
                                                Adquirido
                                            </a>
                                        @else
                                            <form action="{{ route('cart.add') }}" method="POST" class="shrink-0">
                                                @csrf
                                                <input type="hidden" name="game_id" value="{{ $featuredGame->id }}">
                                                <button type="submit" class="px-3 sm:px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-semibold transition-all shadow-md">
                                                    Comprar 🛒
                                                </button>
                                            </form>
                                        @endif
                                    @endguest
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- ================================================= -->
            <!-- 2. SECCIÓN DE BÚSQUEDA, FILTROS Y CATÁLOGO GENERAL -->
            <!-- ================================================= -->
            <div class="space-y-5 sm:space-y-6">
                <div class="flex flex-col gap-4 bg-[#130b24]/70 p-4 sm:p-5 rounded-2xl border border-purple-500/20">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-black text-white tracking-wide">CATÁLOGO GENERAL</h2>
                            <p class="text-xs text-gray-400">Selección de alto rendimiento autorizada por el protocolo.</p>
                        </div>

                        <!-- Barra de Búsqueda Rápida -->
                        <div class="relative w-full md:w-72">
                            <input type="text"
                                   x-model="searchQuery"
                                   placeholder="Buscar juego por título..."
                                   class="w-full bg-[#0b0614] border border-purple-500/40 rounded-xl pl-3.5 pr-8 py-2 text-xs sm:text-sm text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 transition">
                            <button type="button"
                                    x-show="searchQuery.length > 0"
                                    @click="searchQuery = ''"
                                    style="display: none;"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white text-xs">
                                ✕
                            </button>
                        </div>
                    </div>

                    <!-- Botones de Filtrado Interactivo (Alpine.js) -->
                    <div class="flex gap-2 overflow-x-auto pb-1 sm:flex-wrap sm:overflow-visible">
                        <button @click="activeFilter = 'all'"
                                :class="activeFilter === 'all' ? 'bg-purple-600 text-white shadow-[0_0_12px_rgba(168,85,247,0.4)]' : 'bg-[#1b1035] text-gray-400 hover:text-white'"
                                class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs font-semibold transition-all border border-purple-500/30 shrink-0">
                            Todos
                        </button>

                        @foreach(\App\Models\Game::GENRES as $genreOption)
                            <button @click="activeFilter = @js($genreOption)"
                                    :class="activeFilter === @js($genreOption) ? 'bg-purple-600 text-white shadow-[0_0_12px_rgba(168,85,247,0.4)]' : 'bg-[#1b1035] text-gray-400 hover:text-white'"
                                    class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs font-semibold transition-all border border-purple-500/30 shrink-0">
                                {{ $genreOption }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Cuadrícula Dinámica Responsiva conectada a la Base de Datos -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-5">
                    @foreach($games as $game)
                        <div x-show="matchesGame(@js($game->title), @js($game->genre))"
                             x-transition
                             class="rounded-2xl bg-[#130b24]/85 backdrop-blur-md border border-purple-500/30 overflow-hidden flex flex-col justify-between shadow-xl hover:border-purple-500 transition-all">
                            <a href="{{ route('games.show', $game->id) }}" class="h-36 sm:h-48 overflow-hidden relative block group">
                                <img src="{{ $game->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $game->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <span class="hidden sm:inline-block absolute top-3 right-3 bg-purple-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow">DISPONIBLE</span>
                            </a>
                            
                            <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between space-y-2.5 sm:space-y-3">
                                <div>
                                    <a href="{{ route('games.show', $game->id) }}" class="hover:text-cyan-400 transition-colors">
                                        <h3 class="font-bold text-white text-xs sm:text-base mb-1 hover:text-cyan-400 transition-colors line-clamp-1">{{ $game->title }}</h3>
                                    </a>
                                    @if(!empty($game->genre))
                                        <span class="inline-block text-[9px] sm:text-[10px] font-semibold text-cyan-300 bg-cyan-950/60 border border-cyan-500/30 px-2 py-0.5 rounded-md mb-1 line-clamp-1">
                                            {{ $game->genre }}
                                        </span>
                                    @endif
                                    <p class="hidden sm:block text-[11px] text-gray-400 leading-relaxed line-clamp-2">{{ $game->description }}</p>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pt-2.5 border-t border-purple-950/80">
                                    <span class="text-purple-400 font-extrabold text-xs sm:text-sm">${{ number_format($game->price, 2) }} MXN</span>
                                    
                                    @guest
                                        <a href="{{ route('register') }}" class="w-full sm:w-auto py-1.5 sm:py-2 px-2.5 sm:px-3 rounded-xl font-medium text-white bg-purple-600 hover:bg-purple-500 transition-all text-[11px] sm:text-xs shadow-md text-center">
                                            Comprar 🛒
                                        </a>
                                    @else
                                        @if(in_array($game->id, $ownedGameIds ?? []))
                                            <a href="{{ route('library.index') }}" class="w-full sm:w-auto py-1.5 sm:py-2 px-2.5 sm:px-3 rounded-xl font-medium text-emerald-300 bg-emerald-950/80 border border-emerald-500/40 transition-all text-[11px] sm:text-xs text-center">
                                                Adquirido
                                            </a>
                                        @else
                                            <form action="{{ route('cart.add') }}" method="POST" class="w-full sm:w-auto">
                                                @csrf
                                                <input type="hidden" name="game_id" value="{{ $game->id }}">
                                                <button type="submit" class="w-full py-1.5 sm:py-2 px-2.5 sm:px-3 rounded-xl font-medium text-white bg-purple-600 hover:bg-purple-500 transition-all text-[11px] sm:text-xs shadow-md">
                                                    Comprar 🛒
                                                </button>
                                            </form>
                                        @endif
                                    @endguest
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- ========================================================= -->
    <!-- SCRIPTS DE SEGURIDAD (Inactividad y Sesión - 15 minutos) -->
    <!-- ========================================================= -->
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

</x-app-layout>