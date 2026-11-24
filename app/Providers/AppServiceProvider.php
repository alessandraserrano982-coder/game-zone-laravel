<?php

namespace App\Providers;

use App\Models\Library;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $ownedGameIds = Auth::check()
                ? Library::where('user_id', Auth::id())->pluck('game_id')->toArray()
                : [];

            $view->with('ownedGameIds', $ownedGameIds);
        });
    }
}