<?php

namespace DigitalWheat\Shopify\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WebhooksController extends Controller
{
    public function __construct()
    {
        $this->middleware(['bindings', 'throttle:60', 'shopify.webhook_signed']);
    }

    public function uninstall(Request $request)
    {
        app('shopify.user')->forShop($request->header('X-Shopify-Shop-Domain'))->uninstall();
    }
}