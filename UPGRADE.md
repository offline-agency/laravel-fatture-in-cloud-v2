# Upgrading from v2.x to v3.0

## Requirements

| | v2.x | v3.x |
|---|---|---|
| PHP | ^8.1 | ^8.4 |
| Laravel | ^9.0\|^10.0 | ^11.0\|^12.0\|^13.0 |

## Breaking Changes

### API Class Renames

| v2.x | v3.x |
|---|---|
| `ArchiveDocument` | `Archive` |
| `Cashbooks` | `Cashbook` |
| `Settings` (monolithic) | `VatType`, `PaymentAccount`, `PaymentMethod` |

### Entity Properties — snake_case → camelCase

All entity properties now use camelCase. Common mappings:

| v2.x | v3.x |
|---|---|
| `$entity->amount_gross` | `$entity->amountGross` |
| `$entity->amount_net` | `$entity->amountNet` |
| `$entity->vat_number` | `$entity->vatNumber` |
| `$entity->tax_code` | `$entity->taxCode` |
| `$entity->created_at` | `$entity->createdAt` |
| `$entity->updated_at` | `$entity->updatedAt` |
| `$entity->first_name` | `$entity->firstName` |
| `$entity->last_name` | `$entity->lastName` |
| `$entity->payment_method` | `$entity->paymentMethod` |
| `$entity->default_vat` | `$entity->defaultVat` |

### Readonly Entities

All entity classes are now `readonly`. Properties cannot be modified after construction. If you were modifying entity properties directly, you'll need to create new instances instead.

### Connector Changes

- Use `FattureInCloud` (new connector) instead of `LaravelFattureInCloudV2` (deprecated)
- Direct API construction: `new Client()` uses the default company config
- Named company: `new Client(new FattureInCloud(companyName: 'secondary'))`

### Facade Change

The facade now resolves to `FattureInCloudManager` (was `FattureInCloud`). This enables fluent API access:

```php
// v3.x (recommended)
LaravelFattureInCloudV2::clients()->list();

// v2.x style (still works)
$api = new Client();
$api->list();
```

### New Manager Pattern

```php
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade as FIC;

// Fluent access
$clients = FIC::clients()->list();
$invoices = FIC::issuedDocuments()->list(IssuedDocumentType::Invoice);

// Multi-company
$acmeClients = FIC::forCompany('acme')->clients()->list();
```

### Enums

String-backed enums are now available for document types:

```php
use OfflineAgency\LaravelFattureInCloudV2\Enums\IssuedDocumentType;

// New (recommended)
$invoices = $api->list(IssuedDocumentType::Invoice);

// Old (still works)
$invoices = $api->list('invoice');
```

### Config Changes

- `baseUrl` must be the root API URL without path segments
- `limits.max_retries` added (default 3) — API throttle handler now has bounded retries

### Retry Behavior

The API throttle handler now uses bounded retry with exponential backoff instead of infinite recursion. After `max_retries` failed attempts, an `Error` is returned instead of retrying forever.

## Step-by-Step Migration

1. Update `composer.json`: `"offline-agency/laravel-fatture-in-cloud-v2": "^3.0"`
2. Update PHP to >= 8.4
3. Update import paths for renamed API classes
4. Update entity property access to camelCase
5. Re-publish config: `php artisan vendor:publish --tag=config --force`
6. Run `./vendor/bin/pest` to verify
