# Upgrading from 3.0 to 3.1

3.1 adds features without removing any public methods, but a few behaviours changed. Check these if you rely on them.

### Laravel 11 is no longer supported

Laravel 11 reached end of life in March 2026 and every 11.x release has open security advisories, so Composer refuses to install it by default. 3.1 requires Laravel 12 or 13. On Laravel 11, Composer keeps installing 3.0.x.

### Rate-limit config

The `limits` config keys changed and all values are now really milliseconds (3.0 passed them to `usleep()`, which takes microseconds, despite the docs saying milliseconds).

```php
// 3.0
'limits' => ['default' => 300000, '403' => 300000, '429' => 3600000],

// 3.1
'limits' => ['max_retries' => 3, 'retry_delay' => 1000, 'max_wait' => 60000],
```

If you published the config file, replace the `limits` block. The old `default`, `403` and `429` keys are ignored.

- Only HTTP 429 is retried, using the `Retry-After` header when present. If it asks for a longer wait than `max_wait`, the `Error` is returned immediately.
- HTTP 403 is no longer retried. Fatture in Cloud uses it for missing scopes, expired licenses and exhausted hourly/monthly quotas, which retrying can't fix.

### Configuration errors throw

- `new FattureInCloud(companyName: 'name')` (and the new `forCompany('name')`) throws `Exceptions\ConfigurationException` when `name` isn't in `companies`. Before, it silently used empty credentials.
- Sending a request with an empty company ID or access token throws `ConfigurationException` instead of calling the API and returning a 401 `Error`. Building API objects without credentials still works; only sending a request throws.
- **Check your test suite.** Tests that fake the API with `Http::fake()` but have no Fatture in Cloud credentials configured now get this exception. Set fake ones in your test setup:

  ```php
  config([
      'fatture-in-cloud-v2.companies.default.id' => '1',
      'fatture-in-cloud-v2.companies.default.bearer' => 'test-token',
  ]);
  ```

### Facade

The facade now resolves to `FattureInCloudManager` (in 3.0 it resolved to the `FattureInCloud` connector), which adds the fluent accessors (`FIC::clients()`, `FIC::forCompany()`, …). The connector methods `getCompanyId()`, `getAccessToken()`, `getBaseUrl()` and `getRequest()` are still available on the facade.

### Deprecated entity classes

Twelve entity classes that no API method returns are deprecated and will be removed in 4.0: `Entities\Info\{ArchiveCategories, CostCenters, PaymentAccounts, PaymentMethods, ProductsCategories, ReceivedDocumentCategories, RevenueCenters}`, `Entities\Settings\{PaymentMethods, SettingsCreate, SettingsCreateVatType, SettingsGetVatType}` and `Entities\Taxes\TaxesCreate`.

### Attachment uploads

`attachment()` on issued documents, received documents and taxes, and `upload()` on the archive, now send the file once (it was sent twice, as a form field and as a file).

`attachment` accepts a string, a stream resource (`fopen(...)`) or a file (`SplFileInfo`, including Laravel's `UploadedFile`). Before, anything other than a string was silently uploaded as an empty file; now an unsupported value throws `InvalidArgumentException`. The file is read once, so retries after a 429 resend the full content.

---

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
