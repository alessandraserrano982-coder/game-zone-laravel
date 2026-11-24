<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        $nameChanged = $user->isDirty('name');
        $emailChanged = $user->isDirty('email');

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($nameChanged && $emailChanged) {
            $message = '¡Tu nombre de usuario y correo electrónico se actualizaron correctamente!';
        } elseif ($emailChanged) {
            $message = '¡Tu correo electrónico se actualizó correctamente!';
        } elseif ($nameChanged) {
            $message = '¡Tu nombre de usuario se actualizó correctamente!';
        } else {
            $message = '¡Tu información de perfil se guardó correctamente!';
        }

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('success', $message);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}