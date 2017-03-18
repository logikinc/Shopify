<?php

namespace DigitalWheat\Shopify;

abstract class ShopifySignature
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    abstract public function validHmac($secret);

    public function validNonce($state)
    {
        return (strlen($state) && $state === $this->request['state']);
    }

    public function validHostname()
    {
        return (bool) preg_match($this->validShopPattern(), $this->request['shop']);
    }

    protected function validShopPattern()
    {
        return '/^([a-z]|[0-9]|\.|-)+myshopify.com$/i';
    }

    protected function message()
    {
        $keysToRemove = ['signature', 'hmac'];

        $parameters = array_diff_key($this->request(), array_flip($keysToRemove));

        return urldecode(http_build_query($parameters));
    }

    protected function hash($message, $secret, $raw = false)
    {
        return hash_hmac($this->hashingAlgorithm(), $message, $secret, $raw);
    }

    protected function hashingAlgorithm()
    {
        return 'sha256';
    }

    protected function request($key = null)
    {
        if ($key) {
            return isset($this->request[$key]) ? $this->request[$key] : null;
        }

        return $this->request;
    }
}