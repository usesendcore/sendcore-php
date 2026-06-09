<?php

namespace SendCore\Resource;

use SendCore\Client;

class Workflows
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list(): array
    {
        return $this->client->request('GET', '/organizations/workflows');
    }

    public function get(string $id): array
    {
        return $this->client->request('GET', '/organizations/workflows/' . $id);
    }

    public function create(array $params): array
    {
        return $this->client->request('POST', '/organizations/workflows', $params);
    }

    public function update(string $id, array $params): array
    {
        return $this->client->request('PUT', '/organizations/workflows/' . $id, $params);
    }

    public function delete(string $id): array
    {
        return $this->client->request('DELETE', '/organizations/workflows/' . $id);
    }

    public function activate(string $id): array
    {
        return $this->client->request('POST', '/organizations/workflows/' . $id . '/activate');
    }

    public function pause(string $id): array
    {
        return $this->client->request('POST', '/organizations/workflows/' . $id . '/pause');
    }

    public function addStep(string $id, array $params): array
    {
        return $this->client->request('POST', '/organizations/workflows/' . $id . '/steps', $params);
    }

    public function updateStep(string $stepId, array $params): array
    {
        return $this->client->request('PUT', '/organizations/workflows/steps/' . $stepId, $params);
    }

    public function deleteStep(string $stepId): array
    {
        return $this->client->request('DELETE', '/organizations/workflows/steps/' . $stepId);
    }

    public function getExecutions(string $id): array
    {
        return $this->client->request('GET', '/organizations/workflows/' . $id . '/executions');
    }

    public function getExecution(string $executionId): array
    {
        return $this->client->request('GET', '/organizations/workflows/executions/' . $executionId);
    }

    public function test(string $id, ?string $email = null): array
    {
        $params = $email !== null ? ['email' => $email] : null;
        return $this->client->request('POST', '/organizations/workflows/' . $id . '/test', $params);
    }
}
