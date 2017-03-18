<?php

namespace DigitalWheat\Shopify\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use DigitalWheat\Shopify\ShopifyResourceFactory;

class InstalledAppController extends Controller
{
    use ValidatesRequests;

    protected $resourceFactory;

    protected $rules = [
        'shop' => 'required|unique:users,domain|max:255',
    ];

    protected $messages = [
        'shop.unique' => 'Store has already been registered',
    ];

    public function __construct(ShopifyResourceFactory $resourceFactory)
    {
        $this->resourceFactory = $resourceFactory;
        $this->middleware('shopify.guest');
        $this->middleware('shopify.shopify_domain')->only('create');
    }

    public function index()
    {
        return view('shopify::auth.signup', ['plans' => config('shopify.app.plans')]);
    }

    public function create(Request $request)
    {
        $this->validate($request, $this->rules, $this->messages);

        $this->resourceFactory->setDomain($request->get('shop').'.myshopify.com');

        session(['plan' => $request->get('plan')]);

        return redirect($this->resourceFactory->oauth()->authorize(
            config('shopify.app.client_id'),
            config('shopify.app.scope'),
            route('shopify.register'),
            $this->state()
        ));
    }

    protected function state()
    {
        session(['state' => Str::random(40)]);

        return session('state');
    }
}