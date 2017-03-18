<?php

namespace DigitalWheat\Shopify\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthorizedUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['shopify.guest', 'shopify.shopify_domain', 'shopify.signed']);
    }

    public function create(Request $request)
    {
        $user = app('shopify.user')->forShop($request->shop);

        auth()->login($user);

        return redirect()->route('shopify.dashboard');
    }
}