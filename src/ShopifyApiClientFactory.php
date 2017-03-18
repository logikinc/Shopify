<?php

namespace DigitalWheat\Shopify;

class ShopifyApiClientFactory implements ApiClientFactory
{
    /**
     * @param string $domain
     * @return ShopifyApiClient
     */
    public function forDomain($domain)
    {
        return $this->buildClient($domain);
    }

    /**
     * @param string $domain
     * @param string $accessToken
     * @return ShopifyApiClient
     */
    public function forDomainWithAccessToken($domain, $accessToken)
    {
        return $this->buildClient($domain, $accessToken);
    }

    private function buildClient($domain, $accessToken = null)
    {
        return new ShopifyApiClient($domain, $accessToken);
    }
}