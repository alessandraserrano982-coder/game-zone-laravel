<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="py-6 sm:py-8 max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 space-y-6 sm:space-y-8 text-gray-100"
         x-data="{
             storageKey: 'gamezone_installed_user_{{ Auth::id() }}',
             installedIds: [],
             installingId: null,
             progress: 0,
             init() {
                 try {
                     const saved = JSON.parse(localStorage.getItem(this.storageKey) || '[]');
                     if (Array.isArray(saved)) {
                         this.installedIds = saved.map(Number);
                     }
                 } catch (e) {
                     this.installedIds = [];
                 }
             },
             isInstalled(id) {
                 return this.installedIds.includes(Number(id));
             },
             installGame(id) {
                 const gameId = Number(id);
                 if (this.isInstalled(gameId) || this.installingId !== null) return;

                 this.installingId = gameId;
                 this.progress = 10;

                 const interval = setInterval(() => {
                     this.progress = Math.min(100, this.progress + 30);
                     if (this.progress >= 100) {
                         clearInterval(interval);
                         setTimeout(() => {
                             if (!this.installedIds.includes(gameId)) {
                                 this.installedIds.push(gameId);
                                 localStorage.setItem(this.storageKey, JSON.stringify(this.installedIds));
                             }
                             this.installingId = null;
                             this.progress = 0;
                         }, 250);
                     }
                 }, 550);
             },
             uninstallGame(id) {
                 const gameId = Number(id);
                 this.installedIds = this.installedIds.filter(item => item !== gameId);
                 localStorage.setItem(this.storageKey, JSON.stringify(this.installedIds));
             }
         }">
        
        <div class="text-center">
            <h1 class="text-2xl sm:text-4xl font-black uppercase tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 drop-shadow-[0_0_15px_rgba(168,85,247,0.4)]">
                BIBLIOTECA DE JUEGOS
            </h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 sm:gap-6">
            
            <!-- BARRA LATERAL IZQUIERDA -->
            <div class="md:col-span-1 bg-[#120924] border border-purple-500/30 rounded-2xl p-4 shadow-xl h-fit">
                <h3 class="text-xs font-mono uppercase tracking-wider text-gray-400 mb-3 px-2">
                    Juegos ({{ $libraries->count() }})
                </h3>
                
                <div class="space-y-1.5 max-h-[45vh] md:max-h-[70vh] overflow-y-auto pr-1">
                    @if($libraries->count() > 0)
                        @foreach($libraries as $lib)
                            <a href="#game-{{ $lib->game->id }}" class="flex items-center justify-between px-2.5 py-2 rounded-xl hover:bg-purple-900/40 text-gray-300 hover:text-cyan-400 transition text-xs sm:text-sm font-medium group">
                                <div class="flex items-center space-x-2.5 min-w-0">
                                    <img src="{{ $lib->game->image ?? 'https://via.placeholder.com/150' }}" alt="{{ $lib->game->title }}" class="w-7 h-7 sm:w-8 sm:h-8 object-cover rounded-lg border border-purple-500/30 group-hover:border-cyan-400 transition shrink-0">
                                    <span class="truncate">{{ $lib->game->title ?? 'Juego' }}</span>
                                </div>
                                <span x-show="isInstalled({{ $lib->game->id }})" class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)] shrink-0" title="Instalado en PC"></span>
                            </a>
                        @endforeach
                    @else
                        <p class="text-xs text-gray-500 font-mono px-2">Sin juegos</p>
                    @endif
                </div>
            </div>

            <!-- PANEL PRINCIPAL -->
            <div class="md:col-span-3 space-y-5 sm:space-y-6">
                
                <div class="hidden sm:block bg-gradient-to-r from-[#160c2b] to-[#130b24] border border-purple-500/40 rounded-2xl p-6 shadow-2xl">
                    <span class="text-xs font-mono text-cyan-400 uppercase tracking-widest bg-cyan-950/50 px-3 py-1 rounded-full border border-cyan-500/30">
                        Acceso verificado
                    </span>
                    <h3 class="text-2xl font-black text-white mt-3 mb-2">¡Bienvenido a tu colección personal!</h3>
                    <p class="text-sm text-gray-300 max-w-xl">
                        Instala tus títulos en PC o consulta tu colección desde cualquier dispositivo.
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-5">
                    @if($libraries->count() > 0)
                        @foreach($libraries as $lib)
                            <div id="game-{{ $lib->game->id }}" class="bg-[#120924] border border-purple-500/30 rounded-2xl overflow-hidden shadow-xl hover:border-cyan-400/60 transition group flex flex-col justify-between">
                                
                                <div class="h-32 sm:h-44 overflow-hidden relative border-b border-purple-500/20">
                                    <img src="{{ $lib->game->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $lib->game->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    <div class="absolute top-2.5 left-2.5">
                                        <span class="md:hidden text-[9px] font-mono uppercase tracking-wider bg-[#0b0614]/90 text-cyan-300 px-2 py-0.5 rounded-md border border-purple-500/30">
                                            En biblioteca
                                        </span>
                                        <span x-show="isInstalled({{ $lib->game->id }})"
                                              class="hidden md:inline-block text-[10px] font-mono uppercase tracking-wider bg-emerald-950/90 text-emerald-300 px-2.5 py-1 rounded-lg border border-emerald-500/40">
                                            Instalado
                                        </span>
                                        <span x-show="!isInstalled({{ $lib->game->id }})"
                                              class="hidden md:inline-block text-[10px] font-mono uppercase tracking-wider bg-[#0b0614]/90 text-amber-300 px-2.5 py-1 rounded-lg border border-amber-500/30">
                                            No instalado
                                        </span>
                                    </div>
                                </div>

                                <div class="p-3 sm:p-4 space-y-2.5 sm:space-y-3 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h4 class="font-black text-sm sm:text-lg text-white mb-0.5 sm:mb-1 group-hover:text-cyan-400 transition line-clamp-1">
                                            {{ $lib->game->title ?? 'Juego' }}
                                        </h4>
                                        <p class="hidden sm:block text-xs text-gray-400 line-clamp-2">
                                            {{ $lib->game->description ?? 'Disfruta de este gran título directamente desde tu biblioteca digital.' }}
                                        </p>
                                    </div>

                                    <!-- MÓVIL / TABLET CHICA (< md) -->
                                    <div class="md:hidden space-y-1.5 pt-1">
                                        <a href="{{ route('games.show', $lib->game->id) }}"
                                           class="block w-full py-2 px-3 rounded-xl bg-purple-600/90 hover:bg-purple-500 text-white font-bold text-[11px] text-center tracking-wider transition">
                                            Ver detalles
                                        </a>
                                        <p class="text-[10px] font-mono text-gray-500 text-center">
                                            Disponible para instalar en PC
                                        </p>
                                    </div>

                                    <!-- PC / ESCRITORIO (>= md) -->
                                    <div class="hidden md:block space-y-2 pt-1">
                                        <div x-show="installingId === {{ $lib->game->id }}" style="display: none;" class="space-y-1.5">
                                            <div class="flex justify-between text-[11px] font-mono text-cyan-300">
                                                <span>Instalando...</span>
                                                <span x-text="progress + '%'"></span>
                                            </div>
                                            <div class="w-full h-2 rounded-full bg-[#0b0614] overflow-hidden border border-purple-500/30">
                                                <div class="h-full bg-gradient-to-r from-purple-500 to-cyan-400 transition-all duration-300" :style="'width: ' + progress + '%'"></div>
                                            </div>
                                        </div>

                                        <button type="button"
                                                x-show="!isInstalled({{ $lib->game->id }}) && installingId !== {{ $lib->game->id }}"
                                                @click="installGame({{ $lib->game->id }})"
                                                class="w-full py-2.5 rounded-xl bg-gradient-to-r from-cyan-600 to-purple-600 hover:from-cyan-500 hover:to-purple-500 text-white font-bold text-xs tracking-wider shadow-[0_0_15px_rgba(6,182,212,0.35)] transition flex items-center justify-center space-x-2">
                                            <span>⬇️ INSTALAR</span>
                                        </button>

                                        <div x-show="isInstalled({{ $lib->game->id }})" style="display: none;" class="space-y-1.5">
                                            <button type="button"
                                                    class="w-full py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs tracking-wider shadow-[0_0_15px_rgba(168,85,247,0.4)] transition flex items-center justify-center space-x-2">
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                                <span>JUGAR AHORA</span>
                                            </button>
                                            <div class="flex items-center justify-between text-[11px] font-mono pt-0.5">
                                                <a href="{{ route('games.show', $lib->game->id) }}" class="text-cyan-400 hover:underline">Detalles</a>
                                                <button type="button" @click="uninstallGame({{ $lib->game->id }})" class="text-gray-400 hover:text-rose-400 transition">
                                                    Desinstalar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center py-16 bg-[#120924] border border-purple-500/20 rounded-2xl">
                            <p class="text-gray-400 font-mono text-sm">Tu biblioteca está vacía. ¡Explora el catálogo y adquiere tu primer juego!</p>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>