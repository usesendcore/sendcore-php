<?php

namespace SendCore\Resource;

use SendCore\Client;

class Domains
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list(): array
    {
        return $this->client->request('GET', '/domains');
    }

    public function add(array $params): array
    {
        return $this->client->request('POST', '/domains', $params);
    }

    public function remove(string $id): array
    {
        return $this->client->request('DELETE', '/domains/' . $id);
    }

    public function verify(string $id): array
    {
        return $this->client->request('POST', '/domains/' . $id . '/verify');
    }

    public function getDnsRecords(string $id): array
    {
        return $this->client->request('GET', '/domains/' . $id . '/dns');
    }

    public function health(string $id): array
    {
        return $this->client->request('GET', '/domains/' . $id . '/health');
    }
}
