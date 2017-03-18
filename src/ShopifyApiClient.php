<?php

namespace DigitalWheat\Shopify;

use GuzzleHttp\Client;

class ShopifyApiClient implements ApiClient
{
    private $client;

    private $response;

    public function __construct($domain, $accessToken = null)
    {
        $this->client = $this->buildClient($domain, $accessToken);
    }

    private function buildClient($domain, $accessToken = null)
    {
        return new Client([
            'base_uri' => 'https://'.trim($domain, '/').'/admin/',
            'headers' => ['X-Shopify-Access-Token' => $accessToken],
        ]);
    }

    public function response()
    {
        return $this->response;
    }

    public function endpoint($path)
    {
        return $this->client->getConfig('base_uri').trim($path, '/');
    }

    public function request($method, $uri, array $options = [])
    {
        return $this->response = $this->client->$method($uri, $options);
    }

    public function get($uri, array $options = [])
    {
        return $this->parse($this->request('get', $uri, $options));
    }

    public function post($uri, array $options = [])
    {
        return $this->parse($this->request('post', $uri, $options));
    }

    public function put($uri, array $options = [])
    {
        return $this->parse($this->request('put', $uri, $options));
    }

    public function delete($uri, array $options = [])
    {
        return $this->parse($this->request('delete', $uri, $options));
    }

    private function parse($response)
    {
        $body = (string) $response->getBody();

        if ($body === '') {
            return [];
        }

        return json_decode($body, true);
    }
}