<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InitializePusher
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Make sure Pusher is properly initialized for authenticated users
        if (auth()->check()) {
            view()->share('pusherConfig', [
                'key' => config('chatify.pusher.key'),
                'cluster' => config('chatify.pusher.options.cluster'),
                'encrypted' => config('chatify.pusher.options.encrypted'),
            ]);
        }

        return $next($request);
    }
}