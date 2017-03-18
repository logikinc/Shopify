<?php

namespace DigitalWheat\Shopify\Controllers;

use Illuminate\Routing\Controller;

class ExpiredSessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('shopify.guest');
    }

    public function index()
    {
        return view('shopify::app.expired_session');
    }
}