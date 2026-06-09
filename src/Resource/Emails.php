<?php

namespace SendCore\Resource;

use SendCore\Client;
use SendCore\SendEmailParams;

class Emails
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function send(SendEmailParams $params): array
    {
        return $this->client->request('POST', '/emails/send', $params->toArray());
    }

    public function logs(int $page = 1, int $limit = 50): array
    {
        return $this->client->request('GET', '/emails/logs?page=' . $page . '&limit=' . $limit);
    }

    public function getLog(string $id): array
    {
        return $this->client->request('GET', '/emails/logs/' . $id);
    }

    public function stats(): array
    {
        return $this->client->request('GET', '/emails/stats');
    }

    public function analytics(int $days = 30): array
    {
        return $this->client->request('GET', '/emails/analytics?days=' . $days);
    }
}
