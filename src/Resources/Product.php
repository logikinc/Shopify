<?php

namespace DigitalWheat\Shopify\Resources;

class Product extends Resource
{
    public function all($query = '')
    {
        $response = $this->client->get("products.json{$query}");

        return $response['products'];
    }

    public function get($id, $query = '')
    {
        $response = $this->client->get("products/{$id}.json{$query}");

        return $response['product'];
    }

    public function count($query = '')
    {
        $response = $this->client->get("products/count.json{$query}");

        return $response['count'];
    }

    public function create($product)
    {
        $response = $this->client->post('products.json', [
            'json' => [
                'product' => $product,
            ],
        ]);

        return $response['product'];
    }

    public function update($id, $product)
    {
        $response = $this->client->put("products/{$id}.json", [
            'json' => [
                'product' => $product,
            ],
        ]);

        return $response['product'];
    }

    public function delete($id)
    {
        $this->client->delete("products/{$id}.json");

        return $this->client->response()->getStatusCode();
    }
}