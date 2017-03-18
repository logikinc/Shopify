<?php

namespace DigitalWheat\Shopify;

use Illuminate\Cache\Repository;

class ApiCallsCache implements ApiCallsStore
{
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function put($domain, CallLimit $limit)
    {
        $this->cache->put($this->key($domain), $limit, 1);
    }

    public function get($domain)
    {
        return $this->cache->get($this->key($domain), $this->buildCallLimit());
    }

    protected function key($domain)
    {
        return "api.limit.{$domain}";
    }

    protected function buildCallLimit()
    {
        return new CallLimit();
    }
}