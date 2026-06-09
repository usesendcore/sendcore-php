<?php

namespace SendCore\Exception;

class SendCoreException extends \RuntimeException
{
    private int $statusCode;
    private array $detail;

    public function __construct(int $statusCode, array $detail = [])
    {
        $this->statusCode = $statusCode;
        $this->detail = $detail;
        $message = $detail['message'] ?? $detail['error'] ?? 'SendCore API error';
        parent::__construct($message, $statusCode);
    }

    public function isRateLimited(): bool
    {
        return $this->statusCode === 429;
    }

    public function isUnauthorized(): bool
    {
        return $this->statusCode === 401;
    }

    public function isServerError(): bool
    {
        return $this->statusCode >= 500;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getDetail(): array
    {
        return $this->detail;
    }
}
