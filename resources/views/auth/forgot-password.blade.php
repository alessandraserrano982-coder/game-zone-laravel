<x-guest-layout>
    <div class="w-full max-w-md mx-auto px-4 py-12">
        
        <!-- Tarjeta Contenedora Principal -->
        <div class="bg-[#120924] border border-purple-500/40 rounded-3xl p-8 sm:p-10 shadow-[0_0_50px_rgba(168,85,247,0.25)] relative overflow-hidden">
            
            <!-- Resplandor neón superior decorativo -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-24 bg-gradient-to-b from-cyan-500/20 to-transparent blur-xl pointer-events-none"></div>

            <!-- Título Estilizado -->
            <div class="text-center mb-6 relative z-10">
                <h1 class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 tracking-widest uppercase">
                    RECUPERAR ACCESO
                </h1>
                <p class="text-xs text-gray-400 mt-3 leading-relaxed">
                    ¿Olvidaste tu contraseña? No te preocupes. Ingresa tu correo electrónico registrado y te enviaremos un enlace de restablecimiento para definir una nueva clave.
                </p>
            </div>

            <!-- Estado de la sesión / aviso de éxito -->
            <x-auth-session-status class="mb-4 text-xs text-cyan-400 text-center" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5 relative z-10">
                @csrf

                <!-- Campo de Correo -->
                <div>
                    <label class="block text-xs font-mono uppercase text-gray-400 mb-1">Correo Electrónico</label>
                    <input type="email" name="email" :value="old('email')" required autofocus placeholder="correo@gamezone.com"
                        class="w-full bg-[#0b0614] border border-[#7c3aed] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-400 transition">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-400" />
                </div>

                <!-- Botón de Enviar enlace -->
                <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-black text-xs tracking-widest uppercase shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_25px_rgba(147,51,234,0.7)] transition">
                    ENVIAR ENLACE DE RECUPERACIÓN 🔑
                </button>

                <!-- Botón para regresar al Login -->
                <div class="text-center pt-3 border-t border-purple-950/80">
                    <a href="{{ route('login') }}" class="text-xs font-bold text-cyan-400 hover:text-cyan-300 transition underline">
                        ← Volver al inicio de sesión
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>