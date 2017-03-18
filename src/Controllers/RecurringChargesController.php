<?php

namespace DigitalWheat\Shopify\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DigitalWheat\Shopify\ShopifyResourceFactory;

class RecurringChargesController extends Controller
{
    protected $request;

    protected $resourceFactory;

    public function __construct(ShopifyResourceFactory $resourceFactory)
    {
        $this->resourceFactory = $resourceFactory;
        $this->middleware('shopify.login');
        $this->middleware(['shopify.charged'])->only('update');
    }

    public function index()
    {
        $plans_history = $this->getPlansHistory();
        return view('shopify::app.plans', [
            'plans' => config('shopify.app.plans'),
            'plans_history' => $plans_history
        ]);
    }

    public function create(Request $request)
    {
        $plan = config("shopify.app.plans.{$request->plan}");
        $charge = $this->charge()->create($plan);

        return view('shopify::redirect_escape_iframe', ['redirect' => $charge['confirmation_url']]);
    }

    public function update(Request $request)
    {
        $id = $request->charge_id;

        $charge = $this->charge();
        if ($charge->isAccepted($id)) {
            $charge->activate($id);
            auth()->user()->update(['charge_id' => $id]);
        }

        return redirect()->route('shopify.dashboard');
    }

    protected function charge()
    {
        return $this->resourceFactory->setUser(auth()->user())->resource('RecurringApplicationCharge');
    }

    protected function getPlansHistory()
    {
        return $this->resourceFactory->setUser(auth()->user())->resource('RecurringApplicationCharge')->all();
    }
}