<?php

namespace SendCore\Resource;

use SendCore\Client;

class Suppressions
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list(?array $filters = null): array
    {
        $path = '/organizations/suppressions';
        if ($filters !== null) {
            $query = http_build_query($filters);
            $path .= '?' . $query;
        }
        return $this->client->request('GET', $path);
    }

    public function add(array $params): array
    {
        return $this->client->request('POST', '/organizations/suppressions', $params);
    }

    public function remove(string $id): array
    {
        return $this->client->request('DELETE', '/organizations/suppressions/' . $id);
    }
}
