<?php

namespace DigitalWheat\Shopify;

class CallLimitApiClientFactory implements ApiClientFactory
{
    private $callsCollection;

    public function __construct(ApiCallsCollection $callsCollection)
    {
        $this->callsCollection = $callsCollection;
    }

    public function forDomain($domain)
    {
        return $this->buildApiClient($domain);
    }

    public function forDomainWithAccessToken($domain, $accessToken)
    {
        return $this->buildApiClient($domain, $accessToken);
    }

    private function buildApiClient($domain, $accessToken = null)
    {
        return new CallLimitApiClient(new ShopifyApiClient($domain, $accessToken), $this->callsCollection);
    }
}