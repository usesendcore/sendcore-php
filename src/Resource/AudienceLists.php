<?php

namespace SendCore\Resource;

use SendCore\Client;

class AudienceLists
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list(): array
    {
        return $this->client->request('GET', '/organizations/audience/lists');
    }

    public function create(array $params): array
    {
        return $this->client->request('POST', '/organizations/audience/lists', $params);
    }

    public function update(string $id, array $params): array
    {
        return $this->client->request('PUT', '/organizations/audience/lists/' . $id, $params);
    }

    public function delete(string $id): array
    {
        return $this->client->request('DELETE', '/organizations/audience/lists/' . $id);
    }

    public function addContact(array $params): array
    {
        return $this->client->request('POST', '/organizations/audience/contacts', $params);
    }

    public function listContacts(?string $listId = null): array
    {
        $path = '/organizations/audience/contacts';
        if ($listId !== null) {
            $path .= '?listId=' . urlencode($listId);
        }
        return $this->client->request('GET', $path);
    }
}
