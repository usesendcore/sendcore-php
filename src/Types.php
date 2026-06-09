<?php

namespace SendCore;

class SendEmailParams
{
    public function __construct(
        public readonly string $from,
        public readonly string $to,
        public readonly ?string $subject = null,
        public readonly ?string $html = null,
        public readonly ?string $text = null,
        public readonly ?array $cc = null,
        public readonly ?array $bcc = null,
        public readonly ?string $replyTo = null,
        public readonly ?array $attachments = null,
        public readonly ?array $tags = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'from' => $this->from,
            'to' => $this->to,
            'subject' => $this->subject,
            'html' => $this->html,
            'text' => $this->text,
            'cc' => $this->cc,
            'bcc' => $this->bcc,
            'replyTo' => $this->replyTo,
            'attachments' => $this->attachments,
            'tags' => $this->tags,
        ], fn($v) => $v !== null);
    }
}

class SendEmailResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
    ) {}
}

class Domain
{
    public function __construct(
        public readonly string $id,
        public readonly string $domain,
        public readonly string $status,
        public readonly ?bool $verified = null,
        public readonly ?string $createdAt = null,
    ) {}
}

class DnsRecord
{
    public function __construct(
        public readonly string $type,
        public readonly string $name,
        public readonly string $value,
        public readonly ?string $priority = null,
    ) {}
}

class Broadcast
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $status,
        public readonly ?string $subject = null,
        public readonly ?string $fromEmail = null,
        public readonly ?string $fromName = null,
        public readonly ?string $listId = null,
        public readonly ?string $templateId = null,
        public readonly ?string $scheduledAt = null,
        public readonly ?string $createdAt = null,
        public readonly ?int $sentCount = null,
        public readonly ?int $openCount = null,
        public readonly ?int $clickCount = null,
    ) {}
}

class CreateBroadcastParams
{
    public function __construct(
        public readonly string $name,
        public readonly string $listId,
        public readonly ?string $subject = null,
        public readonly ?string $fromEmail = null,
        public readonly ?string $fromName = null,
        public readonly ?string $templateId = null,
        public readonly ?string $html = null,
        public readonly ?string $text = null,
        public readonly ?string $scheduledAt = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'listId' => $this->listId,
            'subject' => $this->subject,
            'fromEmail' => $this->fromEmail,
            'fromName' => $this->fromName,
            'templateId' => $this->templateId,
            'html' => $this->html,
            'text' => $this->text,
            'scheduledAt' => $this->scheduledAt,
        ], fn($v) => $v !== null);
    }
}

class AudienceList
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?int $contactCount = null,
        public readonly ?string $createdAt = null,
    ) {}
}

class AddContactParams
{
    public function __construct(
        public readonly string $email,
        public readonly ?string $listId = null,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?array $customFields = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'email' => $this->email,
            'listId' => $this->listId,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'customFields' => $this->customFields,
        ], fn($v) => $v !== null);
    }
}

class EmailTemplate
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $subject = null,
        public readonly ?string $html = null,
        public readonly ?string $text = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
    ) {}
}

class Suppression
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $reason,
        public readonly ?string $createdAt = null,
    ) {}
}

class ApiKey
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $key = null,
        public readonly ?string $createdAt = null,
    ) {}
}

class CreateApiKeyResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $key,
    ) {}
}

class VerificationResult
{
    public function __construct(
        public readonly string $email,
        public readonly string $status,
        public readonly ?float $score = null,
        public readonly ?string $reason = null,
    ) {}
}

class AnalyticsData
{
    public function __construct(
        public readonly int $totalSent,
        public readonly int $totalDelivered,
        public readonly int $totalOpened,
        public readonly int $totalClicked,
        public readonly int $totalBounced,
        public readonly int $totalComplained,
        public readonly float $openRate,
        public readonly float $clickRate,
        public readonly float $bounceRate,
        public readonly ?array $daily = null,
    ) {}
}

class SubscribeParams
{
    public function __construct(
        public readonly string $email,
        public readonly ?string $listId = null,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?array $customFields = null,
        public readonly ?bool $doubleOptIn = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'email' => $this->email,
            'listId' => $this->listId,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'customFields' => $this->customFields,
            'doubleOptIn' => $this->doubleOptIn,
        ], fn($v) => $v !== null);
    }
}

class Workflow
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $status,
        public readonly ?string $listId = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?array $steps = null,
    ) {}
}

class WorkflowStep
{
    public function __construct(
        public readonly string $id,
        public readonly string $workflowId,
        public readonly string $type,
        public readonly ?WorkflowStepConfig $config = null,
        public readonly ?int $order = null,
        public readonly ?int $delayMinutes = null,
    ) {}
}

class WorkflowStepConfig
{
    public function __construct(
        public readonly ?string $templateId = null,
        public readonly ?string $subject = null,
        public readonly ?string $html = null,
        public readonly ?string $text = null,
        public readonly ?string $fromEmail = null,
        public readonly ?string $fromName = null,
        public readonly ?string $condition = null,
        public readonly ?string $webhookUrl = null,
    ) {}
}

class WorkflowExecution
{
    public function __construct(
        public readonly string $id,
        public readonly string $workflowId,
        public readonly string $contactEmail,
        public readonly string $status,
        public readonly ?string $startedAt = null,
        public readonly ?string $completedAt = null,
        public readonly ?array $logs = null,
    ) {}
}

class WorkflowExecutionLog
{
    public function __construct(
        public readonly string $id,
        public readonly string $stepId,
        public readonly string $stepType,
        public readonly string $status,
        public readonly ?string $message = null,
        public readonly ?string $timestamp = null,
    ) {}
}

class CreateWorkflowParams
{
    public function __construct(
        public readonly string $name,
        public readonly string $listId,
        public readonly ?string $trigger = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'listId' => $this->listId,
            'trigger' => $this->trigger,
        ], fn($v) => $v !== null);
    }
}
