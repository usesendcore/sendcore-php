<?php

namespace SendCore\Resource;

use SendCore\Client;

class Webhooks
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function verifySignature(string $payload, string $signature, string $secret): bool
    {
        $computed = hash_hmac('sha256', $payload, $secret);
        return hash_equals($computed, $signature);
    }
}
