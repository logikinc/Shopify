<?php

namespace DigitalWheat\Shopify\Middleware;

use Closure;
use DigitalWheat\Shopify\ShopifySignatureHttp;

class SignedByShopify
{
    protected $signature;

    protected $secret;

    public function __construct(ShopifySignatureHttp $signature)
    {
        $this->signature = $signature;
        $this->secret = config('shopify.app.client_secret');
    }

    public function handle($request, Closure $next)
    {
        if ($request->has('hmac') && $this->signature->validHmac($this->secret)) {
            return $next($request);
        }

        app()->abort(403, 'Client Error: 403 - Invalid Signature');
    }
}