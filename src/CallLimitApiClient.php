<?php

namespace DigitalWheat\Shopify;

class CallLimitApiClient implements ApiClient
{
    private $client;

    private $apiCalls;

    private $oneMillion = 1000000000;

    public function __construct(ApiClient $client, ApiCallsCollection $apiCalls)
    {
        $this->client = $client;
        $this->apiCalls = $apiCalls;
    }

    public function endpoint($path)
    {
        return $this->client->endpoint($path);
    }

    private function request($method, $uri, array $options = [])
    {
        $domain = $this->endpoint('/');

        if ($wait = $this->apiCalls->addRequest($domain)->waitTime($domain)) {
            usleep($wait * $this->oneMillion);
        }

        $response = $this->client->$method($uri, $options);

        $this->apiCalls->handleResponse($domain, $this->client->response());

        return $response;
    }

    public function get($uri, array $options = [])
    {
        return $this->request('get', $uri, $options);
    }

    public function post($uri, array $options = [])
    {
        return $this->request('post', $uri, $options);
    }

    public function put($uri, array $options = [])
    {
        return $this->request('put', $uri, $options);
    }

    public function delete($uri, array $options = [])
    {
        return $this->request('delete', $uri, $options);
    }

    public function response()
    {
        return $this->client->response();
    }
}