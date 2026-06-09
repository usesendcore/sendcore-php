# SendCore PHP SDK

Official PHP SDK for the [SendCore](https://sendcore.io) email delivery platform.

## Requirements

- PHP 8.1 or higher
- cURL extension
- JSON extension

## Installation

```bash
composer require sendcore/sendcore-php
```

## Quick Start

```php
require 'vendor/autoload.php';

use SendCore\Client;
use SendCore\SendEmailParams;

$client = new Client('your-api-key');

// Send an email
$response = $client->emails->send(new SendEmailParams(
    from: 'sender@example.com',
    to: 'recipient@example.com',
    subject: 'Hello from SendCore',
    html: '<h1>Hello!</h1>',
    text: 'Hello!'
));

echo $response['id'];
```

## Configuration

```php
$client = new Client([
    'apiKey' => 'your-api-key',
    'baseUrl' => 'https://api.sendcore.io',
    'timeout' => 30,
    'retries' => 3,
]);
```

## Usage

### Emails

```php
// Send email
$response = $client->emails->send(new SendEmailParams(
    from: 'sender@example.com',
    to: 'recipient@example.com',
    subject: 'Hello',
    html: '<h1>Hello!</h1>',
    text: 'Hello!',
    cc: ['cc@example.com'],
    bcc: ['bcc@example.com'],
    replyTo: 'support@example.com',
    tags: ['welcome', 'signup'],
));

// Email logs
$logs = $client->emails->logs(page: 1, limit: 50);
$log  = $client->emails->getLog('log-id');

// Stats & analytics
$stats     = $client->emails->stats();
$analytics = $client->emails->analytics(days: 30);
```

### Domains

```php
// List domains
$domains = $client->domains->list();

// Add domain
$domain = $client->domains->add(['domain' => 'example.com']);

// Verify domain
$result = $client->domains->verify('domain-id');

// DNS records
$records = $client->domains->getDnsRecords('domain-id');

// Health check
$health = $client->domains->health('domain-id');

// Remove domain
$client->domains->remove('domain-id');
```

### Contacts (Subscribe/Unsubscribe)

```php
// Subscribe
$result = $client->contacts->subscribe([
    'email'     => 'user@example.com',
    'listId'    => 'list-id',
    'firstName' => 'John',
    'lastName'  => 'Doe',
]);

// Unsubscribe
$result = $client->contacts->unsubscribe([
    'email'  => 'user@example.com',
    'listId' => 'list-id',
]);
```

### Broadcasts

```php
// List broadcasts
$broadcasts = $client->broadcasts->list();

// Get broadcast
$broadcast = $client->broadcasts->get('broadcast-id');

// Create broadcast
$broadcast = $client->broadcasts->create([
    'name'        => 'March Newsletter',
    'listId'      => 'list-id',
    'subject'     => 'Hello',
    'fromEmail'   => 'newsletter@example.com',
    'fromName'    => 'SendCore',
    'html'        => '<h1>Content</h1>',
]);

// Update broadcast
$client->broadcasts->update('broadcast-id', ['subject' => 'New Subject']);

// Send broadcast
$client->broadcasts->send('broadcast-id');

// Schedule broadcast
$client->broadcasts->schedule('broadcast-id', [
    'scheduledAt' => '2026-06-10T09:00:00Z',
]);

// Delete broadcast
$client->broadcasts->delete('broadcast-id');
```

### Audience Lists

```php
// List lists
$lists = $client->audienceLists->list();

// Create list
$list = $client->audienceLists->create(['name' => 'Newsletter Subscribers']);

// Update list
$client->audienceLists->update('list-id', ['name' => 'Updated Name']);

// Delete list
$client->audienceLists->delete('list-id');

// Add contact to list
$client->audienceLists->addContact([
    'email'    => 'user@example.com',
    'listId'   => 'list-id',
    'firstName'=> 'John',
    'lastName' => 'Doe',
]);

// List contacts (optional filter by listId)
$contacts = $client->audienceLists->listContacts('list-id');
$contacts = $client->audienceLists->listContacts();
```

### Templates

```php
// List templates
$templates = $client->templates->list();

// Get template
$template = $client->templates->get('template-id');

// Create template
$template = $client->templates->create([
    'name'    => 'Welcome Email',
    'subject' => 'Welcome!',
    'html'    => '<h1>Welcome</h1>',
    'text'    => 'Welcome',
]);

// Update template
$client->templates->update('template-id', ['subject' => 'New Subject']);

// Delete template
$client->templates->delete('template-id');
```

### Suppressions

```php
// List suppressions (with optional filters)
$suppressions = $client->suppressions->list(['email' => 'bounce@example.com']);
$all = $client->suppressions->list();

// Add suppression
$client->suppressions->add([
    'email'  => 'spam@example.com',
    'reason' => 'spam',
]);

// Remove suppression
$client->suppressions->remove('suppression-id');
```

### API Keys

```php
// List API keys
$keys = $client->apiKeys->list();

// Create API key
$key = $client->apiKeys->create(['name' => 'My App Key']);

// Create MCP key
$key = $client->apiKeys->createMcp('MCP Key');

// Revoke API key
$client->apiKeys->revoke('key-id');
```

### Email Verification

```php
// Verify single email
$result = $client->verification->verify(['email' => 'user@example.com']);

// Batch verify
$results = $client->verification->batch([
    'emails' => ['user1@example.com', 'user2@example.com'],
]);
```

### Analytics

```php
// Get analytics (default 30 days)
$analytics = $client->analytics->get(30);

// Get stats
$stats = $client->analytics->stats();
```

### Webhooks

```php
// Verify webhook signature
$isValid = $client->webhooks->verifySignature(
    payload: $requestBody,
    signature: $incomingSignature,
    secret: 'your-webhook-secret',
);
```

### Workflows

```php
// List workflows
$workflows = $client->workflows->list();

// Get workflow
$workflow = $client->workflows->get('workflow-id');

// Create workflow
$workflow = $client->workflows->create([
    'name'   => 'Welcome Series',
    'listId' => 'list-id',
]);

// Update workflow
$client->workflows->update('workflow-id', ['name' => 'Updated Name']);

// Activate / pause
$client->workflows->activate('workflow-id');
$client->workflows->pause('workflow-id');

// Manage steps
$step = $client->workflows->addStep('workflow-id', [
    'type'         => 'send_email',
    'templateId'   => 'template-id',
    'delayMinutes' => 60,
    'order'        => 1,
]);
$client->workflows->updateStep('step-id', ['delayMinutes' => 120]);
$client->workflows->deleteStep('step-id');

// Executions
$executions = $client->workflows->getExecutions('workflow-id');
$execution  = $client->workflows->getExecution('execution-id');

// Test workflow
$client->workflows->test('workflow-id', 'test@example.com');

// Delete workflow
$client->workflows->delete('workflow-id');
```

## Error Handling

```php
use SendCore\Exception\SendCoreException;

try {
    $client->emails->send($params);
} catch (SendCoreException $e) {
    if ($e->isRateLimited()) {
        // 429 Too Many Requests
    } elseif ($e->isUnauthorized()) {
        // 401 Unauthorized
    } elseif ($e->isServerError()) {
        // 5xx Server Error
    }
    echo $e->getMessage();
    var_dump($e->getDetail());
    echo $e->getStatusCode();
}
```
