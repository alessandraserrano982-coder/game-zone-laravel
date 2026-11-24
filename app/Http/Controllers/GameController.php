<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $games = Game::all();
            return view('admin.games.index', compact('games'));
        }

        $games = Game::where('status', 1)->get();
        return view('games.index', compact('games'));
    }

    public function show(Game $game)
    {
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';

        if ((int) $game->status !== 1 && ! $isAdmin) {
            abort(404);
        }

        return view('games.show', compact('game'));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|url',
            'release_date' => 'nullable|date',
            'developer' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'minimum_requirements' => 'nullable|string',
            'recommended_requirements' => 'nullable|string',
            'trailer_url' => 'nullable|url|max:255',
        ]);

        $validated['stock'] = 10;

        Game::create($validated);

        return redirect()->route('admin.games.index')->with('success', '¡Videojuego agregado con éxito al sistema!');
    }

    public function edit(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|url',
            'release_date' => 'nullable|date',
            'developer' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'minimum_requirements' => 'nullable|string',
            'recommended_requirements' => 'nullable|string',
            'trailer_url' => 'nullable|url|max:255',
        ]);

        $game->update($validated);

        return redirect()->route('admin.games.index')->with('success', '¡Videojuego actualizado correctamente!');
    }

    public function destroy(Game $game)
    {
        $game->update(['status' => 0]);

        return redirect()->route('admin.games.index')->with('success', '¡Videojuego eliminado del catálogo correctamente!');
    }
}