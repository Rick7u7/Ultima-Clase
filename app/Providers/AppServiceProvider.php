<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'local'){
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
        }
        View::share('datos', [
            'textos' => [
                'logo' => '/assets/imgs/logo_sonkei_v2.webp',
                'nombre' => 'Sonkei FC',
            ],
        ]);
    }
}
