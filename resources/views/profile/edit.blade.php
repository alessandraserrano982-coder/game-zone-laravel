<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 tracking-widest uppercase">
                {{ __('Perfil de Usuario') }}
            </h1>
            <a href="{{ route('games.index') }}" class="text-xs font-bold text-purple-300 hover:text-cyan-400 tracking-wider transition bg-purple-950/60 px-3 py-1.5 rounded-xl border border-purple-500/30">
                ← Volver al Catálogo
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Tarjeta de Información de Perfil -->
        <div class="bg-[#120924] border border-purple-500/40 rounded-3xl p-6 sm:p-8 shadow-2xl">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Tarjeta de Actualizar Contraseña -->
        <div class="bg-[#120924] border border-purple-500/40 rounded-3xl p-6 sm:p-8 shadow-2xl">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Tarjeta de Eliminar Cuenta -->
        <div class="bg-[#120924] border border-rose-500/30 rounded-3xl p-6 sm:p-8 shadow-2xl">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</x-app-layout>