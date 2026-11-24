<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="py-8 sm:py-10 max-w-5xl mx-auto px-3 sm:px-6 lg:px-8 space-y-6 sm:space-y-8 text-gray-100">
        
        <!-- TÍTULO PRINCIPAL CON DEGRADADO NEÓN -->
        <div class="text-center">
            <h1 class="text-2xl sm:text-4xl font-black uppercase tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 drop-shadow-[0_0_15px_rgba(168,85,247,0.4)]">
                MÉTODOS DE PAGO
            </h1>
            <p class="text-xs text-gray-400 mt-2">
                Confirma tu método de pago para agregar los juegos a tu biblioteca personal.
            </p>
        </div>

        @php
            $items = $cartItems ?? \App\Models\CartItem::where('user_id', Auth::id())->with('game')->get();
            $total = 0;
        @endphp

        @if(count($items) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8" x-data="{ paymentMethod: 'card' }">
                
                <!-- Columna Izquierda: Resumen del Pedido -->
                <div class="lg:col-span-1 bg-[#120924] border border-purple-500/40 rounded-3xl p-5 sm:p-6 shadow-2xl space-y-4 h-fit">
                    <h3 class="text-xs font-mono uppercase tracking-widest text-cyan-400 pb-3 border-b border-purple-500/30">
                        Resumen del Pedido
                    </h3>

                    <div class="space-y-3 max-h-[40vh] overflow-y-auto pr-1">
                        @foreach($items as $item)
                            @php
                                $price = $item->game->price ?? 0;
                                $qty = $item->quantity ?? 1;
                                $subtotal = $price * $qty;
                                $total += $subtotal;
                            @endphp
                            <div class="flex items-center justify-between gap-2 text-xs">
                                <span class="text-gray-300 truncate">
                                    {{ $item->game->title ?? 'Juego' }}
                                    @if($qty > 1)
                                        <span class="text-cyan-400 font-mono">x{{ $qty }}</span>
                                    @endif
                                </span>
                                <span class="text-purple-400 font-bold shrink-0">
                                    ${{ number_format($subtotal, 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4 border-t border-purple-950/80 flex items-center justify-between">
                        <span class="text-xs font-bold text-white uppercase">Total:</span>
                        <span class="text-base font-black text-cyan-400">
                            ${{ number_format($total, 2) }} MXN
                        </span>
                    </div>
                </div>

                <!-- Columna Derecha: Selección de Método y Confirmación -->
                <div class="lg:col-span-2 bg-[#120924] border border-purple-500/40 rounded-3xl p-5 sm:p-8 shadow-2xl">
                    <form action="{{ route('cart.checkout') }}" method="POST" class="space-y-5">
                        @csrf

                        <h3 class="text-sm font-mono uppercase tracking-widest text-purple-300 pb-3 border-b border-purple-500/30">
                            Selecciona Método de Pago
                        </h3>

                        <!-- Opciones de Pago -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label @click="paymentMethod = 'card'"
                                   :class="paymentMethod === 'card' ? 'border-cyan-400 bg-purple-950/40' : 'border-purple-500/30 bg-[#0b0614]'"
                                   class="flex items-center justify-center p-3.5 sm:p-4 rounded-2xl border cursor-pointer hover:bg-purple-950/40 transition">
                                <input type="radio" name="payment_method" value="card" x-model="paymentMethod" class="sr-only">
                                <span class="text-xs font-bold text-white uppercase">Tarjeta 💳</span>
                            </label>

                            <label @click="paymentMethod = 'paypal'"
                                   :class="paymentMethod === 'paypal' ? 'border-cyan-400 bg-purple-950/40' : 'border-purple-500/30 bg-[#0b0614]'"
                                   class="flex items-center justify-center p-3.5 sm:p-4 rounded-2xl border cursor-pointer hover:bg-purple-950/40 transition">
                                <input type="radio" name="payment_method" value="paypal" x-model="paymentMethod" class="sr-only">
                                <span class="text-xs font-bold text-white uppercase">PayPal 🌐</span>
                            </label>

                            <label @click="paymentMethod = 'crypto'"
                                   :class="paymentMethod === 'crypto' ? 'border-cyan-400 bg-purple-950/40' : 'border-purple-500/30 bg-[#0b0614]'"
                                   class="flex items-center justify-center p-3.5 sm:p-4 rounded-2xl border cursor-pointer hover:bg-purple-950/40 transition">
                                <input type="radio" name="payment_method" value="crypto" x-model="paymentMethod" class="sr-only">
                                <span class="text-xs font-bold text-white uppercase">Cripto ⚡</span>
                            </label>
                        </div>

                        <!-- Campos si es Tarjeta -->
                        <div x-show="paymentMethod === 'card'" class="space-y-4 pt-2">
                            <div>
                                <label class="block text-xs font-mono uppercase text-gray-400 mb-1">Nombre en la Tarjeta</label>
                                <input type="text"
                                       name="card_name"
                                       placeholder="Ej. Luke Thompson"
                                       :required="paymentMethod === 'card'"
                                       class="w-full bg-[#0b0614] border border-[#7c3aed] rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-cyan-400 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-mono uppercase text-gray-400 mb-1">Número de Tarjeta (16 dígitos)</label>
                                <input type="text"
                                       name="card_number"
                                       placeholder="XXXX XXXX XXXX XXXX"
                                       maxlength="16"
                                       minlength="16"
                                       pattern="\d{16}"
                                       title="Debe contener exactamente 16 números"
                                       :required="paymentMethod === 'card'"
                                       class="w-full bg-[#0b0614] border border-[#7c3aed] rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-cyan-400 transition">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-mono uppercase text-gray-400 mb-1">Expiración (MM/AA)</label>
                                    <input type="text"
                                           name="card_expiry"
                                           placeholder="MM/AA"
                                           maxlength="5"
                                           pattern="(0[1-9]|1[0-2])\/\d{2}"
                                           title="Formato válido: MM/AA (ej. 12/28)"
                                           :required="paymentMethod === 'card'"
                                           class="w-full bg-[#0b0614] border border-[#7c3aed] rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-cyan-400 transition">
                                </div>

                                <div>
                                    <label class="block text-xs font-mono uppercase text-gray-400 mb-1">CVV / Código (3-4 dígitos)</label>
                                    <input type="password"
                                           name="card_cvv"
                                           placeholder="123"
                                           maxlength="4"
                                           minlength="3"
                                           pattern="\d{3,4}"
                                           title="Debe ser de 3 o 4 números"
                                           :required="paymentMethod === 'card'"
                                           class="w-full bg-[#0b0614] border border-[#7c3aed] rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-cyan-400 transition">
                                </div>
                            </div>
                        </div>

                        <!-- Campos si es PayPal -->
                        <div x-show="paymentMethod === 'paypal'" class="space-y-4 pt-2" style="display: none;">
                            <div>
                                <label class="block text-xs font-mono uppercase text-gray-400 mb-1">Correo Electrónico de PayPal</label>
                                <input type="email"
                                       name="paypal_email"
                                       placeholder="usuario@paypal.com"
                                       :required="paymentMethod === 'paypal'"
                                       class="w-full bg-[#0b0614] border border-[#7c3aed] rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-cyan-400 transition">
                            </div>
                        </div>

                        <!-- Aviso si es Cripto -->
                        <div x-show="paymentMethod === 'crypto'" class="p-4 rounded-xl bg-[#0b0614] border border-cyan-500/30 text-xs text-gray-300" style="display: none;">
                            Al confirmar la compra se registrarán los títulos directamente en tu biblioteca de Game Zone.
                        </div>

                        <!-- Botón Confirmar Pago -->
                        <button type="submit"
                                class="w-full py-3.5 sm:py-4 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-black text-xs tracking-widest uppercase shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_25px_rgba(147,51,234,0.7)] transition mt-4">
                            CONFIRMAR Y PAGAR ${{ number_format($total, 2) }} MXN 🚀
                        </button>
                    </form>
                </div>

            </div>
        @else
            <div class="text-center py-20 bg-[#120924] border border-purple-500/40 rounded-3xl shadow-2xl space-y-4">
                <p class="text-gray-400 font-mono text-sm">Tu carrito de adquisiciones está vacío.</p>
                <a href="{{ route('games.index') }}" class="inline-block px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs tracking-wider transition shadow-md">
                    Explorar Catálogo 🎮
                </a>
            </div>
        @endif

    </div>
</x-app-layout>