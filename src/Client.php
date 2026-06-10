<?php

namespace SendCore;

use SendCore\Exception\SendCoreException;
use SendCore\Resource\Emails;
use SendCore\Resource\Domains;
use SendCore\Resource\Contacts;
use SendCore\Resource\Broadcasts;
use SendCore\Resource\AudienceLists;
use SendCore\Resource\Templates;
use SendCore\Resource\Suppressions;
use SendCore\Resource\ApiKeys;
use SendCore\Resource\Verification;
use SendCore\Resource\Analytics;
use SendCore\Resource\Webhooks;
use SendCore\Resource\Workflows;
use SendCore\Resource\AgentInboxes;

class Client
{
    private string $apiKey;
    private string $baseUrl;
    private int $timeout;
    private int $retries;

    public Emails $emails;
    public Domains $domains;
    public Contacts $contacts;
    public Broadcasts $broadcasts;
    public AudienceLists $audienceLists;
    public Templates $templates;
    public Suppressions $suppressions;
    public ApiKeys $apiKeys;
    public Verification $verification;
    public Analytics $analytics;
    public Webhooks $webhooks;
    public Workflows $workflows;
    public AgentInboxes $agentInboxes;

    public function __construct(string|array $apiKeyOrConfig)
    {
        if (is_string($apiKeyOrConfig)) {
            $this->apiKey = $apiKeyOrConfig;
            $this->baseUrl = 'https://api.sendcore.io';
            $this->timeout = 30;
            $this->retries = 3;
        } else {
            $this->apiKey = $apiKeyOrConfig['apiKey'] ?? throw new \InvalidArgumentException('apiKey is required');
            $this->baseUrl = rtrim($apiKeyOrConfig['baseUrl'] ?? 'https://api.sendcore.io', '/');
            $this->timeout = $apiKeyOrConfig['timeout'] ?? 30;
            $this->retries = $apiKeyOrConfig['retries'] ?? 3;
        }

        $this->emails = new Emails($this);
        $this->domains = new Domains($this);
        $this->contacts = new Contacts($this);
        $this->broadcasts = new Broadcasts($this);
        $this->audienceLists = new AudienceLists($this);
        $this->templates = new Templates($this);
        $this->suppressions = new Suppressions($this);
        $this->apiKeys = new ApiKeys($this);
        $this->verification = new Verification($this);
        $this->analytics = new Analytics($this);
        $this->webhooks = new Webhooks($this);
        $this->workflows = new Workflows($this);
        $this->agentInboxes = new AgentInboxes($this);
    }

    public function request(string $method, string $path, ?array $body = null): array
    {
        $url = $this->baseUrl . '/api/v1' . $path;
        $attempt = 0;

        while (true) {
            $attempt++;
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => $this->timeout,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'x-api-key: ' . $this->apiKey,
                    'User-Agent: sendcore-php/1.0.0',
                ],
            ]);

            if ($method === 'POST') {
                curl_setopt($ch, CURLOPT_POST, true);
            } elseif ($method !== 'GET') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            }

            if ($body !== null && in_array($method, ['POST', 'PUT', 'PATCH'], true)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            }

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                throw new SendCoreException(0, ['message' => 'cURL error: ' . $curlError]);
            }

            $parsed = json_decode($response, true) ?? [];

            if ($httpCode >= 200 && $httpCode < 300) {
                return $parsed;
            }

            $shouldRetry = in_array($httpCode, [408, 429], true) || $httpCode >= 500;

            if ($shouldRetry && $attempt < $this->retries) {
                $delay = min(1000000 * (2 ** ($attempt - 1)), 10000000);
                usleep((int) $delay);
                continue;
            }

            throw new SendCoreException($httpCode, $parsed);
        }
    }
}
