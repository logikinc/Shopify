<?php

namespace DigitalWheat\Shopify\Middleware;

use Closure;

class LoginShop
{
    public function handle($request, Closure $next)
    {

        if (auth()->check()) {
            return $next($request);
        }

        if ($request->get('shop')) {
            return redirect()->route('shopify.login', $request->all());
        }

        return redirect()->route('shopify.expired');
    }
}