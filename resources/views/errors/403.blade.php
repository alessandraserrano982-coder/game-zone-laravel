<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso No Autorizado - GAME ZONE</title>
    <!-- Cargamos los estilos de tu proyecto -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0b0614] text-gray-100 flex items-center justify-center min-h-screen m-0 font-sans">

    <div class="max-w-md w-full mx-4 p-8 rounded-2xl bg-[#130b24]/90 border border-purple-500/40 text-center shadow-[0_0_35px_rgba(147,51,234,0.3)] backdrop-blur-md space-y-6">
        
        <!-- Código 403 con estilo brillante -->
        <div class="text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">
            403
        </div>

        <h1 class="text-xl font-black uppercase tracking-wider text-white">
            ⚠️ Acceso Restringido
        </h1>

        <p class="text-sm text-gray-400 leading-relaxed">
            Esta sección es de uso exclusivo para el personal administrador. Tu cuenta actual no cuenta con los permisos necesarios para gestionar el sistema central.
        </p>

        <!-- Botones de navegación -->
        <div class="pt-4 flex flex-col gap-3">
            <!-- Botón para regresar al catálogo normal -->
            <a href="{{ route('games.index') }}" class="w-full py-3 px-4 rounded-xl font-bold text-white bg-purple-600 hover:bg-purple-500 transition-all shadow-[0_0_15px_rgba(147,51,234,0.4)] text-sm">
                Volver al Catálogo 🎮
            </a>

            <!-- Botón para ir al login / cambiar de cuenta -->
            <a href="{{ route('login') }}" class="w-full py-3 px-4 rounded-xl font-medium text-purple-300 bg-purple-950/60 border border-purple-500/30 hover:bg-purple-900/60 transition-all text-sm">
                Iniciar sesión con otra cuenta 🔑
            </a>
        </div>

    </div>

</body>
</html>