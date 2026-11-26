<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión Expirada - GAME ZONE</title>
    <!-- Icono para navegador y accesos directos en celular -->
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">
    <meta name="theme-color" content="#0b0614">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0b0614] text-gray-100 font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Fondo decorativo cyberpunk -->
    <div class="absolute inset-0 z-0 opacity-20 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-purple-900 via-indigo-950 to-black"></div>

    <!-- Contenedor Principal de la Alerta -->
    <div class="relative z-10 w-full max-w-2xl mx-4 p-8 rounded-3xl bg-[#120924] border border-purple-500/40 shadow-[0_0_30px_rgba(168,85,247,0.2)] grid grid-cols-1 md:grid-cols-2 gap-6 items-center backdrop-blur-xl">
        
        <!-- Columna de Información -->
        <div>
            <div class="inline-flex items-center gap-2 mb-4">
                <span class="text-[10px] font-mono font-bold tracking-widest uppercase text-rose-400 bg-rose-950/60 px-3 py-1 rounded-full border border-rose-500/30 shadow-[0_0_10px_rgba(244,63,94,0.3)]">
                    Sesión Expirada
                </span>
            </div>

            <!-- Título con degradado neón unificado -->
            <h2 class="text-2xl font-black uppercase tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 mb-3 leading-tight">
                Tu sesión expiró por inactividad
            </h2>
            
            <p class="text-xs text-gray-400 mb-6 leading-relaxed font-mono">
                Por seguridad cerramos tu acceso en este navegador después de un periodo sin actividad. Debes iniciar sesión nuevamente para continuar.
            </p>

            <!-- Botones de Acción -->
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Botón de Iniciar Sesión con estilo cyberpunk unificado -->
                <a href="{{ route('login') }}" class="flex-1 py-3 px-4 text-center rounded-xl font-black text-white bg-gradient-to-r from-purple-600 to-cyan-500 hover:shadow-[0_0_20px_rgba(6,182,212,0.5)] transition-all shadow-[0_0_15px_rgba(147,51,234,0.4)] text-xs tracking-wider uppercase">
                    Iniciar Sesión 🔑
                </a>
                
                <!-- Botón al Portal Principal -->
                <a href="{{ url('/') }}" class="flex-1 py-3 px-4 text-center rounded-xl font-bold text-gray-300 bg-[#0b0614] hover:bg-purple-950/40 hover:text-white transition-all border border-purple-500/30 text-xs tracking-wider uppercase">
                    Portal Principal
                </a>
            </div>
        </div>

        <!-- Columna Visual / Tarjeta de Estado -->
        <div class="bg-[#0b0614]/80 rounded-2xl p-5 border border-purple-500/30 flex flex-col justify-between h-full shadow-inner">
            <div class="text-center py-6">
                <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-purple-950/80 border border-purple-500/40 flex items-center justify-center text-cyan-400 shadow-[0_0_20px_rgba(6,182,212,0.3)]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <span class="text-xs font-mono font-bold text-gray-200 uppercase tracking-wider">Estado del Sistema</span>
            </div>

            <div class="bg-purple-950/40 rounded-xl p-3 border border-purple-500/20">
                <p class="text-[11px] text-gray-400 text-center font-mono">
                    Tu sesión ya no está activa. Inicia nuevamente para continuar.
                </p>
            </div>
        </div>

    </div>

</body>
</html>