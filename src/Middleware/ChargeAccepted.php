<?php

namespace DigitalWheat\Shopify\Middleware;

use Closure;
use DigitalWheat\Shopify\ShopifyResourceFactory;
use Shopify;

class ChargeAccepted
{
    protected $resourceFactory;

    public function __construct(ShopifyResourceFactory $resourceFactory)
    {
        $this->resourceFactory = $resourceFactory;
    }

    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $charge = $this->resourceFactory->setUser($user)->resource('RecurringApplicationCharge');

        if ($user->charge_id && $charge->isAccepted($user->charge_id)) {
            return $next($request);
        }

        return redirect()->route('shopify.plans');
    }

}