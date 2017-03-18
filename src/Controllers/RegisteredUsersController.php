<?php

namespace DigitalWheat\Shopify\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use DigitalWheat\Shopify\ShopifyResourceFactory;
use DigitalWheat\Shopify\ShopifySignatureHttp;

class RegisteredUsersController extends Controller
{
    use ValidatesRequests;

    protected $resourceFactory;

    protected $signature;

    protected $accessToken;

    protected $rules = [
        'state' => 'required',
        'hmac' => 'required',
        'code' => 'required',
    ];

    public function __construct(ShopifyResourceFactory $resourceFactory, ShopifySignatureHttp $signature)
    {
        $this->resourceFactory = $resourceFactory;
        $this->signature = $signature;
        $this->middleware('shopify.shopify_domain');
    }

    public function create(Request $request)
    {
        if ($redirect = $this->verifySignature($request)) {
            return $redirect;
        }

        $this->resourceFactory->setDomain($request->get('shop'))->setAccessToken($this->accessToken());

        auth()->login($this->user($request));

        foreach (config('shopify.app.webhooks') as $webhook) {
            $this->resourceFactory->resource('Webhook')->create($webhook);
        }

        if ($plan = session('plan')) {
            return redirect()->route('shopify.plan.create', compact('plan'));
        }

        return redirect()->route('shopify.dashboard');
    }

    protected function verifySignature(Request $request)
    {
        if ($this->getValidationFactory()->make($request->all(), $this->rules)->fails()) {
            return redirect()->route('shopify.signup')->withErrors('Invalid request');
        }

        if (! $this->signature->validHmac($this->secret()) || ! $this->signature->validHostname()) {
            app()->abort(403, 'Client Error: 403 - Invalid Signature');
        }

        if (! $this->signature->validNonce($request->get('state'))) {
            app()->abort(403, 'Client Error: 403 - Invalid State');
        }
    }

    protected function secret()
    {
        return config('shopify.app.client_secret');
    }

    protected function accessToken()
    {
        return $this->accessToken = $this->resourceFactory->oauth()->accessToken(
            config('shopify.app.client_id'), $this->secret(), request('code')
        );
    }

    protected function user(Request $request)
    {
        $shop = $this->resourceFactory->resource('Shop')->get();

        $user =  app('shopify.user')::where('domain', $shop['myshopify_domain'])->first();
        if($user){
            $user->installApp($this->accessToken);
            return $user;
        }

        return app('shopify.user')->create([
            'shopify_id' => $shop['id'],
            'name' => $shop['name'],
            'email' => $shop['email'],
            'domain' => $shop['myshopify_domain'],
            'access_token' => $this->accessToken,
            'installed' => true,
            'password' => bcrypt(Str::random(20)),
        ]);
    }

}