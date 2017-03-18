<?php

namespace DigitalWheat\Shopify\Middleware;

use Closure;
use DigitalWheat\Shopify\ShopifySignatureWebhook;

class WebhookSignedByShopify
{
    protected $signature;

    protected $secret;

    public function __construct(ShopifySignatureWebhook $signature)
    {
        $this->signature = $signature;
        $this->secret = config('shopify.app.client_secret');
    }

    public function handle($request, Closure $next)
    {
        if ($this->signature->validHmac($this->secret)) {
            return $next($request);
        }

        app()->abort(403, 'Client Error: 403 - Invalid Signature');
    }
}