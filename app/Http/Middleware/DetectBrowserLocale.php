<?php

namespace App\Http\Middleware;

use App\Helpers\LocaleHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectBrowserLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('/') && ! $request->hasCookie('locale')) {
            $locale = LocaleHelper::detectFromRequest($request);

            return redirect('/'.$locale)
                ->cookie('locale', $locale, 60 * 24 * 365);
        }

        return $next($request);
    }
}
