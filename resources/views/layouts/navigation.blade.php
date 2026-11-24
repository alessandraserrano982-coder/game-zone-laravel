<nav x-data="{ open: false, cartDrawerOpen: false }"
     @open-cart.window="cartDrawerOpen = true"
     @toggle-cart.window="cartDrawerOpen = !cartDrawerOpen"
     class="bg-[#0b0614] border-b border-purple-500/30 text-gray-100 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo / Título de la App (Izquierda) -->
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('games.index') }}" class="font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 tracking-widest text-lg uppercase">
                        GAME ZONE
                    </a>
                </div>
            </div>

            <!-- Menú de Enlaces (Derecha, en orden: Catálogo, Biblioteca, Carrito, Perfil) -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                
                <!-- 1. Catálogo -->
                <x-nav-link :href="route('games.index')" :active="request()->routeIs('games.*')" class="text-xs uppercase font-bold tracking-wider text-gray-300 hover:text-cyan-400 transition border-b-2 {{ request()->routeIs('games.*') ? 'border-cyan-400 text-white' : 'border-transparent' }}">
                    {{ __('Catálogo') }}
                </x-nav-link>

                @auth
                    <!-- 2. Biblioteca -->
                    <x-nav-link :href="route('library.index')" :active="request()->routeIs('library.*')" class="text-xs uppercase font-bold tracking-wider text-gray-300 hover:text-cyan-400 transition border-b-2 {{ request()->routeIs('library.*') ? 'border-cyan-400 text-white' : 'border-transparent' }}">
                        {{ __('Biblioteca') }}
                    </x-nav-link>

                    <!-- 3. Carrito (Disparador del Panel Lateral / Drawer) -->
                    <button @click="cartDrawerOpen = true" type="button" class="text-xs uppercase font-bold tracking-wider text-gray-300 hover:text-cyan-400 transition py-2 border-b-2 border-transparent focus:outline-none">
                        {{ __('Carrito') }}
                    </button>
                @endauth

                <!-- 4. Settings Dropdown (Perfil / Logout) sin bordes blancos -->
                @auth
                    <div class="relative ml-3" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" type="button" class="inline-flex items-center px-3 py-2 border border-purple-500/30 text-xs font-mono uppercase tracking-wider rounded-xl text-gray-200 bg-[#120924] hover:border-cyan-400 focus:outline-none transition shadow">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-cyan-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        <!-- Contenedor del Dropdown Oscuro sin bordes blancos -->
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-[#120924] border border-purple-500/40 rounded-xl shadow-2xl py-1 z-50" style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs font-medium text-gray-300 hover:bg-purple-900/50 hover:text-cyan-400 transition">
                                {{ __('Perfil') }}
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-xs font-medium text-gray-300 hover:bg-purple-900/50 hover:text-rose-400 transition">
                                    {{ __('Cerrar Sesión') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-wider text-gray-300 hover:text-cyan-400 transition px-3 py-2">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-purple-600 to-cyan-500 hover:shadow-[0_0_15px_rgba(6,182,212,0.4)] px-4 py-2 rounded-xl transition shadow">
                        Registrarse
                    </a>
                @endauth

            </div>

            <!-- Botón Rápido de Carrito + Hamburger Menu (Móvil) -->
            <div class="-me-2 flex items-center gap-2 sm:hidden">
                @auth
                    <button @click="cartDrawerOpen = true" type="button" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-[#120924] border border-purple-500/30 text-[11px] font-bold uppercase tracking-wider text-cyan-300 hover:border-cyan-400 transition">
                        <span>🛒</span>
                        <span>Carrito</span>
                    </button>
                @endauth

                <button @click="open = ! open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-300 hover:bg-[#120924] focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Móvil) -->
    <div x-show="open" @click.away="open = false" style="display: none;" class="sm:hidden bg-[#120924] border-t border-purple-500/30 px-4 py-3 space-y-2">
        <a href="{{ route('games.index') }}" @click="open = false" class="block px-3 py-2 rounded-xl text-xs font-bold uppercase tracking-wider {{ request()->routeIs('games.*') ? 'bg-purple-900/50 text-cyan-400 border border-cyan-500/30' : 'text-gray-300 hover:bg-purple-900/30 hover:text-cyan-400' }}">
            {{ __('Catálogo') }}
        </a>

        @auth
            <a href="{{ route('library.index') }}" @click="open = false" class="block px-3 py-2 rounded-xl text-xs font-bold uppercase tracking-wider {{ request()->routeIs('library.*') ? 'bg-purple-900/50 text-cyan-400 border border-cyan-500/30' : 'text-gray-300 hover:bg-purple-900/30 hover:text-cyan-400' }}">
                {{ __('Biblioteca') }}
            </a>

            <button @click="cartDrawerOpen = true; open = false" type="button" class="w-full text-left px-3 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-gray-300 hover:bg-purple-900/30 hover:text-cyan-400 transition">
                {{ __('Carrito') }}
            </button>

            <div class="pt-2 mt-2 border-t border-purple-500/20 space-y-1">
                <div class="px-3 py-1 text-[11px] font-mono text-cyan-400 truncate">
                    {{ Auth::user()->name }}
                </div>
                <a href="{{ route('profile.edit') }}" @click="open = false" class="block px-3 py-2 rounded-xl text-xs font-medium text-gray-300 hover:bg-purple-900/30 hover:text-cyan-400 transition">
                    {{ __('Perfil') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-xl text-xs font-medium text-gray-300 hover:bg-purple-900/30 hover:text-rose-400 transition">
                        {{ __('Cerrar Sesión') }}
                    </button>
                </form>
            </div>
        @else
            <div class="pt-2 mt-2 border-t border-purple-500/20 flex flex-col gap-2">
                <a href="{{ route('login') }}" @click="open = false" class="block px-3 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-gray-300 hover:bg-purple-900/30 hover:text-cyan-400">
                    Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" @click="open = false" class="block text-center px-3 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-purple-600 to-cyan-500">
                    Registrarse
                </a>
            </div>
        @endauth
    </div>

    <!-- PANEL LATERAL DESPLEGABLE (DRAWER) SÓLIDO Y DE LARGO TOTAL -->
    @auth
        <div x-show="cartDrawerOpen" class="fixed inset-0 overflow-hidden z-50" style="display: none;">
            <!-- Fondo oscuro sólido -->
            <div @click="cartDrawerOpen = false" class="fixed inset-0 bg-[#05020a]/80 transition-opacity"></div>

            <div class="fixed inset-y-0 right-0 max-w-full flex">
                <div class="w-screen max-w-md bg-[#120924] border-l border-purple-500/40 text-gray-100 p-6 flex flex-col justify-between shadow-2xl h-full">
                    
                    <!-- Cabecera del Drawer -->
                    <div>
                        <div class="flex items-center justify-between pb-4 border-b border-purple-500/30">
                            <h3 class="text-xs font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 tracking-wider uppercase">
                                CARRITO DE ADQUISICIONES
                            </h3>
                            <button @click="cartDrawerOpen = false" type="button" class="text-gray-400 hover:text-rose-400 font-mono text-base">✕</button>
                        </div>

                        <!-- Lista de productos en el carrito usando CartItem -->
                        <div class="mt-6 space-y-4 max-h-[65vh] overflow-y-auto pr-1">
                            @php 
                                $cartItems = \App\Models\CartItem::where('user_id', auth()->id())->with('game')->get();
                                $drawerTotal = 0;
                            @endphp

                            @forelse($cartItems as $item)
                                @php 
                                    $price = $item->game->price ?? 0;
                                    $qty = $item->quantity ?? 1;
                                    $subtotal = $price * $qty;
                                    $drawerTotal += $subtotal;
                                @endphp
                                <div class="flex items-center justify-between bg-[#0b0614] p-3 rounded-xl border border-purple-500/20">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $item->game->image ?? 'https://via.placeholder.com/80' }}" class="w-12 h-12 object-cover rounded-lg border border-purple-500/30">
                                        <div>
                                            <h4 class="font-bold text-xs text-white line-clamp-1">
                                                {{ $item->game->title ?? 'Juego' }}
                                                @if($qty > 1)
                                                    <span class="text-cyan-400 font-mono">x{{ $qty }}</span>
                                                @endif
                                            </h4>
                                            <span class="text-purple-400 font-extrabold text-xs">${{ number_format($subtotal, 2) }} MXN</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[10px] text-rose-400 hover:text-rose-300 font-bold uppercase bg-[#1a0d30] px-2.5 py-1 rounded-lg border border-rose-500/30 transition">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="text-center py-24">
                                    <p class="text-xs text-gray-400 font-mono">Tu carrito está vacío.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pie del Drawer (Total y Botón de Proceder al Pago) -->
                    <div class="pt-4 border-t border-purple-500/30 space-y-4 mt-auto">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono uppercase text-gray-400">Total artículos:</span>
                            <span class="text-sm font-black text-cyan-400">${{ number_format($drawerTotal, 2) }} MXN</span>
                        </div>

                        <a href="{{ route('cart.index') }}" class="block text-center py-3.5 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-black text-xs tracking-widest uppercase shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_25px_rgba(147,51,234,0.7)] transition">
                            PROCEDER AL PAGO 💳
                        </a>
                    </div>

                </div>
            </div>
        </div>
    @endauth
</nav>