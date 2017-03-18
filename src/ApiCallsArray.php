<?php

namespace DigitalWheat\Shopify;

class ApiCallsArray implements ApiCallsStore
{
    private static $limit = [];

    public static function clear()
    {
        static::$limit = [];
    }

    public function put($domain, CallLimit $limit)
    {
        static::$limit[$domain] = $limit;
    }

    public function get($domain)
    {
        return isset(static::$limit[$domain]) ? static::$limit[$domain] : $this->buildCallLimit();
    }

    protected function buildCallLimit()
    {
        return new CallLimit();
    }
}