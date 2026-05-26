<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $view->with('supportedLocales', config('locales.supported', ['en', 'ar', 'hr']));
            $view->with('currentLocale', app()->getLocale());
            $view->with('isRtl', in_array(app()->getLocale(), config('locales.rtl', [])));
        });
    }
}
