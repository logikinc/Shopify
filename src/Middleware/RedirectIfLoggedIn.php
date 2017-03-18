<?php

namespace DigitalWheat\Shopify\Middleware;

use Closure;

class RedirectIfLoggedIn
{
    public function handle($request, Closure $next)
    {
        if(auth()->check() && !auth()->user()->installed) {
            auth()->logout();
        }

        if (auth()->guest()) {
            return $next($request);
        }

        return redirect()->route('shopify.dashboard');
    }
}