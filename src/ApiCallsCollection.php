<?php

namespace DigitalWheat\Shopify;

use GuzzleHttp\Psr7\Response;

class ApiCallsCollection
{
    private $store;

    public function __construct(ApiCallsStore $store)
    {
        $this->store = $store;
    }

    public function requestCount($domain)
    {
        return $this->store->get($domain)->requestCount();
    }

    public function addRequest($domain)
    {
        $calls = $this->store->get($domain)->addRequest();

        $this->store->put($domain, $calls);

        return $this;
    }

    public function handleResponse($domain, Response $response)
    {
        $calls = $this->store->get($domain)->handleResponse($response);

        $this->store->put($domain, $calls);

        return $this;
    }

    public function waitTime($domain)
    {
        return $this->store->get($domain)->waitTime();
    }
}