<?php

namespace SendCore\Resource;

use SendCore\Client;

class Analytics
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(?int $days = null): array
    {
        $path = '/emails/analytics';
        if ($days !== null) {
            $path .= '?days=' . $days;
        }
        return $this->client->request('GET', $path);
    }

    public function stats(): array
    {
        return $this->client->request('GET', '/emails/stats');
    }
}
