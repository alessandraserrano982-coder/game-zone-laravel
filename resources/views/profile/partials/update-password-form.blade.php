<section>
    <header class="mb-6">
        <h2 class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 tracking-wider uppercase">
            {{ __('Actualizar Contraseña') }}
        </h2>
        <p class="text-xs text-gray-400 mt-1 font-mono">
            {{ __('Asegúrate de que tu cuenta utilice una contraseña larga y aleatoria para mantener la seguridad.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña Actual')" class="text-xs font-mono uppercase text-gray-300" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg-[#0b0614] border border-purple-500/40 rounded-xl px-4 py-2.5 text-sm text-white focus:border-cyan-400 focus:ring-cyan-400 transition" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-rose-400 text-xs" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" class="text-xs font-mono uppercase text-gray-300" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full bg-[#0b0614] border border-purple-500/40 rounded-xl px-4 py-2.5 text-sm text-white focus:border-cyan-400 focus:ring-cyan-400 transition" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-rose-400 text-xs" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" class="text-xs font-mono uppercase text-gray-300" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-[#0b0614] border border-purple-500/40 rounded-xl px-4 py-2.5 text-sm text-white focus:border-cyan-400 focus:ring-cyan-400 transition" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-rose-400 text-xs" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-black text-xs tracking-widest uppercase shadow-[0_0_15px_rgba(6,182,212,0.4)] hover:shadow-[0_0_20px_rgba(147,51,234,0.6)] transition">
                {{ __('Actualizar Clave') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="text-xs font-mono text-emerald-400">
                    {{ __('Actualizado con éxito.') }}
                </p>
            @endif
        </div>
    </form>
</section>