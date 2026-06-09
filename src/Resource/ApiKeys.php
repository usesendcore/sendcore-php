<?php

namespace SendCore\Resource;

use SendCore\Client;

class ApiKeys
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list(): array
    {
        return $this->client->request('GET', '/organizations/api-keys');
    }

    public function create(array $params): array
    {
        return $this->client->request('POST', '/organizations/api-keys', $params);
    }

    public function createMcp(string $name): array
    {
        return $this->client->request('POST', '/organizations/api-keys/mcp', ['name' => $name]);
    }

    public function revoke(string $id): array
    {
        return $this->client->request('DELETE', '/organizations/api-keys/' . $id);
    }
}
