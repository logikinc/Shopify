<?php

namespace DigitalWheat\Shopify;

use InvalidArgumentException;

class ShopifyResourceFactory
{
    protected $clientFactory;

    protected $domain;

    protected $accessToken;

    public function __construct(ApiClientFactory $clientFactory, $domain = null, $accessToken = null)
    {
        $this->clientFactory = $clientFactory;
        $this->domain = $domain;
        $this->accessToken = $accessToken;
    }

    public function setUser($user)
    {
        return $this->setDomain($user->domain)->setAccessToken($user->access_token);
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function resource($name)
    {
        $resource = "\\DigitalWheat\\Shopify\\Resources\\{$name}";

        if (! class_exists($resource)) {
            throw new InvalidArgumentException("Resource doesn't exist [{$resource}]");
        }

        return new $resource($this->client());
    }

    public function oauth()
    {
        return new Oauth($this->client());
    }

    public function client()
    {
        return $this->clientFactory->forDomainWithAccessToken($this->domain, $this->accessToken);
    }
}