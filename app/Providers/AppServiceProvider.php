<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('menuList', (object) config('menu'));
        view()->share('currentUrl', 'http://' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN'));
        view()->share('currentSlag', '/');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
