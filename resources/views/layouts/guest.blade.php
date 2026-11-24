<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>GAME ZONE - Auth</title>

        <!-- Icono para navegador y accesos directos en celular -->
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">
        <meta name="theme-color" content="#0b0614">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts / Tailwind de Breeze -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Estilos personalizados Proyecto Vayne (Dark / Neon) -->
        <style>
            body {
                background-color: #0b0614 !important;
                color: #e2d9f3 !important;
            }
            /* Fondo general de la pantalla de autenticación */
            .auth-bg {
                background: radial-gradient(circle at center, #160c2b 0%, #0b0614 100%) !important;
            }
            /* Logo superior */
            .cyber-logo {
                color: #22d3ee !important;
                text-shadow: 0 0 10px rgba(34, 211, 238, 0.8);
                font-weight: 800;
                letter-spacing: 2px;
                text-decoration: none;
            }
            .cyber-logo:hover {
                color: #ffffff !important;
            }
            /* Inputs de texto y contraseñas */
            input[type="text"], input[type="email"], input[type="password"] {
                background-color: #0b0614 !important;
                border: 1px solid #7c3aed !important;
                color: #ffffff !important;
                border-radius: 6px !important;
            }
            input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
                border-color: #22d3ee !important;
                box-shadow: 0 0 10px rgba(34, 211, 238, 0.5) !important;
                outline: none !important;
            }
            label {
                color: #d8b4fe !important;
            }
            a.text-sm {
                color: #22d3ee !important;
            }
            a.text-sm:hover {
                color: #ffffff !important;
                text-shadow: 0 0 8px rgba(34, 211, 238, 0.8);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center py-6 px-4 auth-bg">
            
        <!-- Logo / Título con redirección al inicio -->
            <div class="mb-6 text-center">
                <a href="{{ route('games.index') }}" class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 tracking-widest uppercase hover:opacity-90 transition">
                    GAME ZONE
                </a>
            </div>

            <!-- Contenedor libre para el formulario horizontal -->
            <div class="w-full flex justify-center">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>