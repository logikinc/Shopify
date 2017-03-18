<?php

namespace DigitalWheat\Shopify\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['shopify.login', 'shopify.paying']);
    }

    public function index()
    {
        return view('shopify::app.dashboard', ['user' => auth()->user()]);
    }
}