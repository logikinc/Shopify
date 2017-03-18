<?php

namespace DigitalWheat\Shopify;

interface ApiClient
{
    public function response();

    public function endpoint($path);

    public function get($uri, array $options = []);

    public function post($uri, array $options = []);

    public function put($uri, array $options = []);

    public function delete($uri, array $options = []);
}