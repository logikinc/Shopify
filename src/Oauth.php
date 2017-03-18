<?php

namespace DigitalWheat\Shopify;

class Oauth
{
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function authorize($clientId, $scope, $redirectUri, $state)
    {
        $query = http_build_query([
            'client_id' => $clientId,
            'scope' => $scope,
            'redirect_uri' => $redirectUri,
            'state' => $state,
        ]);

        return $this->client->endpoint("oauth/authorize?{$query}");
    }

    public function accessToken($clientId, $clientSecret, $code)
    {
        $response = $this->client->post('oauth/access_token', [
            'json' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $code,
            ],
        ]);

        return isset($response['access_token']) ? $response['access_token'] : null;
    }
}