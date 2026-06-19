<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteLockMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('site-lock.enabled')) {
            return $next($request);
        }

        if ($request->hasSession() && $request->session()->get('site_lock_passed')) {
            return $next($request);
        }

        if ($this->isExcluded($request)) {
            return $next($request);
        }

        return redirect()->route('site-lock.show');
    }

    protected function isExcluded(Request $request): bool
    {
        if ($request->routeIs('site-lock.show', 'site-lock.unlock')) {
            return true;
        }

        if ($request->is('login', 'logout', 'admin', 'admin/*')) {
            return true;
        }

        return false;
    }
}
