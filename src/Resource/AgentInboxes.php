<?php

namespace SendCore\Resource;

use SendCore\Client;

class AgentInboxes
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(array $params): array
    {
        return $this->client->request('POST', '/agent-inboxes', $params);
    }

    public function list(): array
    {
        return $this->client->request('GET', '/agent-inboxes');
    }

    public function get(string $id): array
    {
        return $this->client->request('GET', '/agent-inboxes/' . $id);
    }

    public function delete(string $id): array
    {
        return $this->client->request('DELETE', '/agent-inboxes/' . $id);
    }

    public function setWebhook(string $id, string $url): array
    {
        return $this->client->request('PUT', '/agent-inboxes/' . $id . '/webhook', ['url' => $url]);
    }

    public function getEmails(string $id, ?int $page = null, ?int $limit = null): array
    {
        $query = [];
        if ($page !== null) $query['page'] = $page;
        if ($limit !== null) $query['limit'] = $limit;
        $qs = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->client->request('GET', '/agent-inboxes/' . $id . '/emails' . $qs);
    }

    public function getEmail(string $inboxId, string $emailId): array
    {
        return $this->client->request('GET', '/agent-inboxes/' . $inboxId . '/emails/' . $emailId);
    }

    public function markAsRead(string $inboxId, string $emailId): array
    {
        return $this->client->request('PUT', '/agent-inboxes/' . $inboxId . '/emails/' . $emailId . '/read');
    }

    public function sendEmail(string $id, array $params): array
    {
        if (is_string($params['to'] ?? null)) {
            $params['to'] = [$params['to']];
        }
        return $this->client->request('POST', '/agent-inboxes/' . $id . '/send', $params);
    }
}
