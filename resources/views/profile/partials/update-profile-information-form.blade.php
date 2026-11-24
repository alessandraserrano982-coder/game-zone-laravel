<section>
    <header class="mb-6">
        <h2 class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 tracking-wider uppercase">
            {{ __('Información del Perfil') }}
        </h2>
        <p class="text-xs text-gray-400 mt-1 font-mono">
            {{ __("Actualiza la información de tu cuenta y dirección de correo electrónico del sistema.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nombre')" class="text-xs font-mono uppercase text-gray-300" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-[#0b0614] border border-purple-500/40 rounded-xl px-4 py-2.5 text-sm text-white focus:border-cyan-400 focus:ring-cyan-400 transition" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-rose-400 text-xs" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-xs font-mono uppercase text-gray-300" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-[#0b0614] border border-purple-500/40 rounded-xl px-4 py-2.5 text-sm text-white focus:border-cyan-400 focus:ring-cyan-400 transition" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-rose-400 text-xs" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-xs mt-2 text-gray-400 font-mono">
                        {{ __('Tu dirección de correo electrónico no está verificada.') }}

                        <button form="send-verification" class="underline text-cyan-400 hover:text-cyan-300 rounded-md focus:outline-none">
                            {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-mono text-xs text-emerald-400">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-black text-xs tracking-widest uppercase shadow-[0_0_15px_rgba(6,182,212,0.4)] hover:shadow-[0_0_20px_rgba(147,51,234,0.6)] transition">
                {{ __('Guardar Cambios') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="text-xs font-mono text-emerald-400">
                    {{ __('Guardado con éxito.') }}
                </p>
            @endif
        </div>
    </form>
</section>