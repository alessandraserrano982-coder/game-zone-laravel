<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta de Sesión - GAME ZONE</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0b0614] text-gray-100 font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Fondo decorativo cyberpunk -->
    <div class="absolute inset-0 z-0 opacity-20 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-purple-900 via-indigo-950 to-black"></div>

    <!-- Contenedor Principal del Modal con estética unificada -->
    <div class="relative z-10 w-full max-w-md mx-4 p-8 rounded-3xl bg-[#120924] border border-purple-500/40 shadow-[0_0_30px_rgba(168,85,247,0.2)] backdrop-blur-xl">
        
        <!-- Encabezado de la alerta -->
        <div class="flex items-center gap-3 mb-6">
            <div class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_10px_#34d399]"></div>
            <span class="text-[10px] font-mono font-bold tracking-widest uppercase text-emerald-400 bg-emerald-950/60 px-3 py-1 rounded-full border border-emerald-500/30 shadow-[0_0_10px_rgba(16,185,129,0.3)]">
                Sesión Activa Detectada
            </span>
        </div>

        <!-- Título principal con degradado neón unificado -->
        <h2 class="text-xl font-black uppercase tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 mb-2 leading-tight">
            Tu cuenta ya está abierta en otro dispositivo
        </h2>
        <p class="text-xs text-gray-400 mb-6 leading-relaxed font-mono">
            Detectamos una sesión activa con tu usuario. Por seguridad y por el protocolo de la red, elige qué deseas hacer:
        </p>

        <!-- Información de seguridad estilizada -->
        <div class="bg-[#0b0614]/80 rounded-2xl p-4 mb-6 border border-purple-500/30 text-xs space-y-2 text-gray-300 font-mono">
            <div class="flex justify-between">
                <span class="text-gray-500">Estado del sistema:</span>
                <span class="text-cyan-400 font-bold">Bloqueo activo</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Protocolo:</span>
                <span class="text-purple-300">GAME ZONE - SECURE</span>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="space-y-3">
            <!-- Formulario para cerrar las otras sesiones y continuar -->
            <form method="POST" action="{{ route('session.close.others') }}">
                @csrf
                <button type="submit" class="w-full py-3 px-4 rounded-xl font-black text-white bg-gradient-to-r from-purple-600 to-cyan-500 hover:shadow-[0_0_20px_rgba(6,182,212,0.5)] transition-all shadow-[0_0_15px_rgba(147,51,234,0.4)] text-xs tracking-wider uppercase">
                    Cerrar sesión en otros dispositivos 🛡️
                </button>
            </form>

            <!-- Botón para cancelar y volver al login -->
            <a href="{{ route('login') }}" class="block w-full py-3 px-4 text-center rounded-xl font-bold text-gray-300 bg-[#0b0614] hover:bg-purple-950/40 hover:text-white transition-all border border-purple-500/30 text-xs tracking-wider uppercase">
                Cancelar
            </a>
        </div>

        <!-- Pie de nota de seguridad -->
        <div class="mt-6 pt-4 border-t border-purple-500/20 text-center">
            <p class="text-[11px] text-gray-500 leading-normal font-mono">
                Si no reconoces esta sesión, te recomendamos cambiar tu contraseña de inmediato.
            </p>
        </div>

    </div>

</body>
</html>