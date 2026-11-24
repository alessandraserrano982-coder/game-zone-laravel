<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Videojuego - GAME ZONE</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0b0614] text-gray-100 font-sans antialiased min-h-screen py-8 px-4 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto"
         x-data="{
             title: @js(old('title', $game->title ?? '')),
             genre: @js(old('genre', $game->genre ?? '')),
             price: @js(old('price', $game->price ?? '')),
             releaseDate: @js(old('release_date', $game->release_date ?? '')),
             developer: @js(old('developer', $game->developer ?? '')),
             publisher: @js(old('publisher', $game->publisher ?? '')),
             image: @js(old('image', $game->image ?? '')),
             trailerUrl: @js(old('trailer_url', $game->trailer_url ?? '')),
             description: @js(old('description', $game->description ?? '')),
             minReq: @js(old('minimum_requirements', $game->minimum_requirements ?? '')),
             recReq: @js(old('recommended_requirements', $game->recommended_requirements ?? ''))
         }">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- Formulario de Edición -->
            <div class="lg:col-span-6 p-6 sm:p-8 rounded-2xl bg-[#130b24]/90 border border-purple-500/40 shadow-[0_0_35px_rgba(147,51,234,0.3)] backdrop-blur-md">
                <h1 class="text-xl font-black text-white uppercase mb-6 tracking-wide text-center">✏️ Editar Videojuego</h1>

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-xl bg-rose-950/70 border border-rose-500/40 text-rose-200 text-xs">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.games.update', $game->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-semibold text-purple-300 mb-1">Título del Videojuego</label>
                        <input type="text" name="title" value="{{ old('title', $game->title) }}" x-model="title" required class="w-full px-4 py-2.5 rounded-xl bg-[#0b0614] border border-purple-500/30 text-white focus:outline-none focus:border-cyan-400">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-purple-300 mb-1">Precio ($ MXN)</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $game->price) }}" x-model="price" required class="w-full px-4 py-2.5 rounded-xl bg-[#0b0614] border border-purple-500/30 text-white focus:outline-none focus:border-cyan-400">
                        </div>

                        <div>
                            <label class="block font-semibold text-purple-300 mb-1">Fecha de Lanzamiento</label>
                            <input type="date" name="release_date" value="{{ old('release_date', $game->release_date) }}" x-model="releaseDate" class="w-full px-4 py-2.5 rounded-xl bg-[#0b0614] border border-purple-500/30 text-white focus:outline-none focus:border-cyan-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-purple-300 mb-1">Desarrollador</label>
                            <input type="text" name="developer" value="{{ old('developer', $game->developer) }}" x-model="developer" placeholder="Ej. Capcom" class="w-full px-4 py-2.5 rounded-xl bg-[#0b0614] border border-purple-500/30 text-white focus:outline-none focus:border-cyan-400">
                        </div>

                        <div>
                            <label class="block font-semibold text-purple-300 mb-1">Distribuidora</label>
                            <input type="text" name="publisher" value="{{ old('publisher', $game->publisher) }}" x-model="publisher" placeholder="Ej. Capcom" class="w-full px-4 py-2.5 rounded-xl bg-[#0b0614] border border-purple-500/30 text-white focus:outline-none focus:border-cyan-400">
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-purple-300 mb-1">Género</label>
                        <select name="genre" x-model="genre" class="w-full px-4 py-2.5 rounded-xl bg-[#0b0614] border border-purple-500/30 text-white focus:outline-none focus:border-cyan-400">
                            @php
                                $selectedGenre = old('genre', $game->genre ?? '');
                            @endphp
                            <option value="">Seleccionar género...</option>
                            @foreach(\App\Models\Game::GENRES as $g)
                                <option value="{{ $g }}" {{ $selectedGenre === $g ? 'selected' : '' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-purple-300 mb-1">URL de la Imagen (Portada)</label>
                        <input type="url" name="image" value="{{ old('image', $game->image) }}" x-model="image" placeholder="https://..." class="w-full px-4 py-2.5 rounded-xl bg-[#0b0614] border border-purple-500/30 text-white focus:outline-none focus:border-cyan-400">
                    </div>

                    <div>
                        <label class="block font-semibold text-purple-300 mb-1">URL del Tráiler (YouTube u otro)</label>
                        <input type="url" name="trailer_url" value="{{ old('trailer_url', $game->trailer_url) }}" x-model="trailerUrl" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-4 py-2.5 rounded-xl bg-[#0b0614] border border-purple-500/30 text-white focus:outline-none focus:border-cyan-400">
                    </div>

                    <div>
                        <label class="block font-semibold text-purple-300 mb-1">Descripción</label>
                        <textarea name="description" rows="3" x-model="description" required class="w-full px-4 py-2.5 rounded-xl bg-[#0b0614] border border-purple-500/30 text-white focus:outline-none focus:border-cyan-400">{{ old('description', $game->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-purple-300 mb-1">Requisitos Mínimos</label>
                        <textarea name="minimum_requirements" rows="3" x-model="minReq" placeholder="SO, Procesador, Memoria RAM, Gráficos, Almacenamiento..." class="w-full px-4 py-2.5 rounded-xl bg-[#0b0614] border border-purple-500/30 text-white focus:outline-none focus:border-cyan-400">{{ old('minimum_requirements', $game->minimum_requirements) }}</textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-purple-300 mb-1">Requisitos Recomendados</label>
                        <textarea name="recommended_requirements" rows="3" x-model="recReq" placeholder="SO, Procesador, Memoria RAM, Gráficos, Almacenamiento..." class="w-full px-4 py-2.5 rounded-xl bg-[#0b0614] border border-purple-500/30 text-white focus:outline-none focus:border-cyan-400">{{ old('recommended_requirements', $game->recommended_requirements) }}</textarea>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="submit" class="flex-1 py-3 rounded-xl font-bold text-white bg-cyan-600 hover:bg-cyan-500 transition-all shadow-[0_0_15px_rgba(6,182,212,0.4)]">
                            Actualizar Cambios 🔄
                        </button>
                        <a href="{{ route('admin.games.index') }}" class="flex-1 py-3 text-center rounded-xl font-medium text-gray-300 bg-gray-800/60 hover:bg-gray-800 transition-all border border-gray-700">
                            Cancelar ❌
                        </a>
                    </div>
                </form>
            </div>

            <!-- Vista Previa en Vivo -->
            <div class="lg:col-span-6 p-6 sm:p-8 rounded-2xl bg-[#130b24]/80 border border-cyan-500/30 shadow-[0_0_30px_rgba(6,182,212,0.15)] space-y-5 text-xs lg:sticky lg:top-6">
                <div class="flex items-center justify-between border-b border-purple-500/20 pb-3">
                    <span class="text-xs font-black uppercase tracking-wider text-cyan-400">👁️ Vista Previa en Tiempo Real</span>
                    <span class="px-2.5 py-1 rounded-md bg-purple-950/80 text-purple-300 border border-purple-500/30 font-semibold" x-text="genre || 'Sin género'"></span>
                </div>

                <div class="rounded-2xl bg-[#0b0614] border border-purple-500/30 overflow-hidden max-w-sm mx-auto shadow-xl">
                    <div class="h-44 bg-[#160c2c] relative flex items-center justify-center overflow-hidden">
                        <img x-show="image" :src="image" class="w-full h-full object-cover" alt="Portada">
                        <span x-show="!image" class="text-gray-500 font-mono px-4 text-center">Pega una URL de portada para previsualizar</span>
                    </div>
                    <div class="p-4 space-y-2">
                        <h2 class="font-bold text-white text-base" x-text="title || 'Título del Videojuego'"></h2>
                        <p class="text-[11px] text-gray-400 line-clamp-2" x-text="description || 'Aquí aparecerá la descripción del videojuego...'"></p>
                        <div class="pt-2 border-t border-purple-950/80 flex items-center justify-between">
                            <span class="text-cyan-400 font-extrabold text-sm" x-text="price ? ('$' + Number(price).toFixed(2) + ' MXN') : '$0.00 MXN'"></span>
                            <span class="text-[10px] px-2.5 py-1 rounded-lg bg-purple-600/40 text-purple-200 border border-purple-500/30">Comprar 🛒</span>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl bg-[#0b0614] border border-purple-500/25 p-4 space-y-4">
                    <div class="p-3 rounded-lg bg-[#130b24]/80 border border-purple-500/20 text-[11px]">
                        <span class="text-gray-500 block mb-1">Enlace de Tráiler:</span>
                        <span class="text-cyan-300 break-all" x-text="trailerUrl || 'Ninguno ingresado'"></span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-[11px] border-t border-b border-purple-500/20 py-3">
                        <div>
                            <span class="text-gray-500 block">Lanzamiento</span>
                            <span class="text-white font-semibold" x-text="releaseDate || 'Por confirmar'"></span>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Desarrollador</span>
                            <span class="text-cyan-300 font-semibold" x-text="developer || 'No especificado'"></span>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Distribuidora</span>
                            <span class="text-purple-300 font-semibold" x-text="publisher || 'No especificado'"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-[11px]">
                        <div class="p-3 rounded-lg bg-[#130b24]/80 border border-purple-500/20">
                            <span class="font-bold text-cyan-400 uppercase block mb-1">Mínimos</span>
                            <p class="text-gray-300 whitespace-pre-line" x-text="minReq || 'No especificados aún.'"></p>
                        </div>
                        <div class="p-3 rounded-lg bg-[#130b24]/80 border border-purple-500/20">
                            <span class="font-bold text-purple-300 uppercase block mb-1">Recomendados</span>
                            <p class="text-gray-300 whitespace-pre-line" x-text="recReq || 'No especificados aún.'"></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>