<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            abort(403, 'Unauthorized');
        }

        $user = auth()->user();

        if (! $user->is_active || ! in_array($user->role, ['admin', 'editor'], true)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
