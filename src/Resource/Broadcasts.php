<?php

namespace SendCore\Resource;

use SendCore\Client;

class Broadcasts
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list(): array
    {
        return $this->client->request('GET', '/organizations/broadcasts');
    }

    public function get(string $id): array
    {
        return $this->client->request('GET', '/organizations/broadcasts/' . $id);
    }

    public function create(array $params): array
    {
        return $this->client->request('POST', '/organizations/broadcasts', $params);
    }

    public function update(string $id, array $params): array
    {
        return $this->client->request('PUT', '/organizations/broadcasts/' . $id, $params);
    }

    public function delete(string $id): array
    {
        return $this->client->request('DELETE', '/organizations/broadcasts/' . $id);
    }

    public function send(string $id): array
    {
        return $this->client->request('POST', '/organizations/broadcasts/' . $id . '/send');
    }

    public function schedule(string $id, array $params): array
    {
        return $this->client->request('POST', '/organizations/broadcasts/' . $id . '/schedule', $params);
    }
}
