<?php

namespace SendCore\Resource;

use SendCore\Client;

class Templates
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list(): array
    {
        return $this->client->request('GET', '/organizations/templates');
    }

    public function get(string $id): array
    {
        return $this->client->request('GET', '/organizations/templates/' . $id);
    }

    public function create(array $params): array
    {
        return $this->client->request('POST', '/organizations/templates', $params);
    }

    public function update(string $id, array $params): array
    {
        return $this->client->request('PUT', '/organizations/templates/' . $id, $params);
    }

    public function delete(string $id): array
    {
        return $this->client->request('DELETE', '/organizations/templates/' . $id);
    }
}
