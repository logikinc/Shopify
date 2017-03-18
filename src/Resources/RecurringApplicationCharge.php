<?php

namespace DigitalWheat\Shopify\Resources;

class RecurringApplicationCharge extends Resource
{
    public function all($query = '')
    {
        $response = $this->client->get("recurring_application_charges.json{$query}");

        return $response['recurring_application_charges'];
    }

    public function get($id, $query = '')
    {
        $response = $this->client->get("recurring_application_charges/{$id}.json{$query}");

        return $response['recurring_application_charge'];
    }

    public function activate($id)
    {
        $response = $this->client->post("recurring_application_charges/{$id}/activate.json", [
            'json' => [
                'recurring_application_charge' => $id,
            ],
        ]);

        return $response['recurring_application_charge'];
    }

    public function create($plan)
    {
        $response = $this->client->post('recurring_application_charges.json', [
            'json' => [
                'recurring_application_charge' => $plan,
            ],
        ]);

        return $response['recurring_application_charge'];
    }

    public function isAccepted($id)
    {
        $charge = $this->get($id);

        return in_array($charge['status'], ['accepted', 'active']);
    }
}