<?php

namespace SendCore\Resource;

use SendCore\Client;

class Contacts
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function subscribe(array $params): array
    {
        return $this->client->request('POST', '/organizations/audience/subscribe', $params);
    }

    public function unsubscribe(array $params): array
    {
        return $this->client->request('POST', '/organizations/audience/unsubscribe', $params);
    }
}
