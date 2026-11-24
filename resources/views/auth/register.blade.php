<x-guest-layout>
    <div class="w-full max-w-5xl mx-auto px-4 py-6">
        <div class="bg-[#120924] border border-purple-500/40 rounded-3xl shadow-[0_0_60px_rgba(168,85,247,0.3)] grid grid-cols-1 lg:grid-cols-2 overflow-hidden">
            
            <!-- Columna Izquierda: Formulario con padding optimizado -->
            <div class="p-6 sm:p-8 flex flex-col justify-center">
                
                <div class="text-center mb-5">
                    <h1 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 tracking-widest uppercase">
                        REGISTRATE AQUÍ
                    </h1>
                    <p class="text-xs text-gray-400 mt-1">Crea tu cuenta para acceder al sistema de adquisiciones.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-3">
                    @csrf

                    <div>
                        <label class="block text-xs font-mono uppercase text-gray-400 mb-1">Nombre de Usuario</label>
                        <input type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="User Name"
                            class="w-full bg-[#0b0614] border border-[#7c3aed] rounded-xl px-4 py-2 text-sm text-white focus:outline-none focus:border-cyan-400 transition">
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase text-gray-400 mb-1">Correo Electrónico</label>
                        <input type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="correo@gmail.com"
                            class="w-full bg-[#0b0614] border border-[#7c3aed] rounded-xl px-4 py-2 text-sm text-white focus:outline-none focus:border-cyan-400 transition">
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase text-gray-400 mb-1">Contraseña</label>
                        <input type="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                            class="w-full bg-[#0b0614] border border-[#7c3aed] rounded-xl px-4 py-2 text-sm text-white focus:outline-none focus:border-cyan-400 transition">
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase text-gray-400 mb-1">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"
                            class="w-full bg-[#0b0614] border border-[#7c3aed] rounded-xl px-4 py-2 text-sm text-white focus:outline-none focus:border-cyan-400 transition">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-black text-xs tracking-widest uppercase shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_25px_rgba(147,51,234,0.7)] transition mt-1">
                        REGISTRARSE 🚀
                    </button>

                    <div class="text-center pt-2 border-t border-purple-950/80">
                        <span class="text-xs text-gray-400">¿Ya tienes una cuenta? </span>
                        <a href="{{ route('login') }}" class="text-xs font-bold text-cyan-400 hover:text-cyan-300 transition underline ml-1">
                            Inicia sesión aquí
                        </a>
                    </div>
                </form>
            </div>

            <!-- Columna Derecha: GIF centrado y ajustado -->
            <div class="relative hidden lg:block bg-[#0b0614] overflow-hidden border-l border-purple-500/20">
                <img src="https://giffiles.alphacoders.com/223/223031.gif" alt="Vayne Background" class="absolute inset-0 w-full h-full object-cover object-center opacity-85">
                <div class="absolute inset-0 bg-gradient-to-t from-[#120924]/80 via-transparent to-transparent"></div>
            </div>

        </div>
    </div>
</x-guest-layout>