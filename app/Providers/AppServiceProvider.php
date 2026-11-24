<?php

namespace App\Providers;

use App\Models\Library;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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
        if ($this->app->environment('production') || str_contains(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $ownedGameIds = Auth::check()
                ? Library::where('user_id', Auth::id())->pluck('game_id')->toArray()
                : [];

            $view->with('ownedGameIds', $ownedGameIds);
        });
    }
}