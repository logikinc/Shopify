<?php

namespace DigitalWheat\Shopify;

interface ApiClientFactory
{
    /**
     * @param string $domain
     * @return ApiClient
     */
    public function forDomain($domain);

    /**
     * @param string $domain
     * @param string $accessToken
     * @return ApiClient
     */
    public function forDomainWithAccessToken($domain, $accessToken);
}