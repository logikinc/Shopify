<?php

namespace DigitalWheat\Shopify;

use GuzzleHttp\Psr7\Response;

class CallLimit
{
    private $bucket_level = 0;

    private $requests = [];

    public function addRequest()
    {
        $this->requests[] = microtime();

        return $this;
    }

    public function handleResponse(Response $response)
    {
        $this->bucket_level = $this->extractBucketLevel($response);

        array_shift($this->requests);

        return $this;
    }

    private function extractBucketLevel(Response $response)
    {
        if (! $headers = $response->getHeader('X-Shopify-Shop-Api-Call-Limit')) {
            return $this->bucketLevel();
        }

        list($level) = array_map('intval', explode('/', $headers[0]));

        return $level;
    }

    public function waitTime()
    {
        return $this->reachedLimit() ? $this->requestCount() * $this->wait() : false;
    }

    public function reachedLimit()
    {
        return $this->bucketLevel() + $this->requestCount() >= $this->limit();
    }

    public function bucketLevel()
    {
        return $this->bucket_level;
    }

    public function requestCount()
    {
        return count($this->requests);
    }

    public function limit()
    {
        return 40;
    }

    private function wait()
    {
        return 0.5;
    }
}