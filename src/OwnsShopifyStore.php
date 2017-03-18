<?php

namespace DigitalWheat\Shopify;

trait OwnsShopifyStore
{

    public function forShop($shop)
    {
        return static::whereDomain($shop)->first();
    }

    public function isActive()
    {
        return (bool) $this->installed;
    }

    public function install()
    {
        return $this->update(['installed' => true]);
    }

    public function installApp($value)
    {
        $this->update(['installed' => true]);
        $this->update(['access_token' => $value]);
    }

    public function uninstall()
    {
        return $this->update(['installed' => false]);
    }

    public function setAccessTokenAttribute($value)
    {
        $this->attributes['access_token'] = encrypt($value);
    }

    public function getAccessTokenAttribute()
    {
        return decrypt($this->attributes['access_token']);
    }

    public function getCurrentPlan(){
        $resourceFactory = new ShopifyResourceFactory(app(config('shopify.app.api.client_factory')));
        $plan_details = $resourceFactory->setUser(auth()->user())->resource('RecurringApplicationCharge')->get($this->charge_id);
        return $plan_details['name'];
    }



}