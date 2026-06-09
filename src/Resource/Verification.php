<?php

namespace SendCore\Resource;

use SendCore\Client;

class Verification
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function verify(array $params): array
    {
        return $this->client->request('POST', '/email-verification/verify', $params);
    }

    public function batch(array $params): array
    {
        return $this->client->request('POST', '/email-verification/batch-verify', $params);
    }
}
