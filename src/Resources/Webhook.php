<?php

namespace DigitalWheat\Shopify\Resources;

class Webhook extends Resource
{
    public function all($query = '')
    {
        $response = $this->client->get("webhooks.json{$query}");

        return $response['webhooks'];
    }

    public function get($id, $query = '')
    {
        $response = $this->client->get("webhooks/{$id}.json{$query}");

        return $response['webhook'];
    }

    public function count($query = '')
    {
        $response = $this->client->get("webhooks/count.json{$query}");

        return $response['count'];
    }

    public function create($webhook)
    {
        if (! isset($webhook['format'])) {
            $webhook['format'] = 'json';
        }

        $response = $this->client->post('webhooks.json', [
            'json' => [
                'webhook' => $webhook,
            ],
        ]);

        return $response['webhook'];
    }

    public function update($id, $webhook)
    {
        $response = $this->client->put("webhooks/{$id}.json", [
            'json' => [
                'webhook' => $webhook,
            ],
        ]);

        return $response['webhook'];
    }

    public function delete($id)
    {
        $this->client->delete("webhooks/{$id}.json");

        return $this->client->response()->getStatusCode();
    }
}