<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // В проде принудительно генерируем HTTPS ссылки (важно за reverse-proxy).
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
        view()->composer( 'components.language_switcher', function ( $view ) {
            $view->with( 'current_locale', app()->getLocale() );
            $view->with( 'available_locales', config( 'app.available_locales' ) );
        } );
    }
}
