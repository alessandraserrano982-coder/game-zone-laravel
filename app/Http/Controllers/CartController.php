<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Mostrar los elementos del carrito del usuario autenticado
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('game')->get();
        return view('cart.index', compact('cartItems'));
    }

    // Agregar un juego al carrito
    public function add(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
        ]);

        $userId = Auth::id();
        $gameId = $request->input('game_id');

        // Buscar si el usuario ya tiene este juego en el carrito
        $cartItem = CartItem::where('user_id', $userId)
                            ->where('game_id', $gameId)
                            ->first();

        if ($cartItem) {
            // Si ya existe, solo aumentamos en 1
            $cartItem->increment('quantity');
        } else {
            // Si no existe, lo creamos con cantidad 1
            CartItem::create([
                'user_id' => $userId,
                'game_id' => $gameId,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', '¡Se agregó correctamente al carrito!');
    }

    // Procesar la compra y mover los juegos a la biblioteca
    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:card,paypal,crypto',
            'card_name' => 'required_if:payment_method,card|nullable|string|max:255',
            'card_number' => 'required_if:payment_method,card|nullable|digits:16',
            'card_expiry' => ['required_if:payment_method,card', 'nullable', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
            'card_cvv' => 'required_if:payment_method,card|nullable|digits_between:3,4',
            'paypal_email' => 'required_if:payment_method,paypal|nullable|email|max:255',
        ]);

        $userId = Auth::id();
        $cartItems = CartItem::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Tu carrito está vacío.');
        }

        foreach ($cartItems as $item) {
            \App\Models\Library::firstOrCreate([
                'user_id' => $userId,
                'game_id' => $item->game_id,
            ]);
        }

        CartItem::where('user_id', $userId)->delete();

        return redirect()->route('library.index')->with('success', '¡Adquisición procesada con éxito!');
    }

    // Eliminar un producto del carrito
    public function remove($id)
    {
        $cartItem = CartItem::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Producto eliminado del carrito.');
    }
}