# Laravel Fatture in Cloud

[![Latest Version on Packagist](https://img.shields.io/packagist/v/offline-agency/laravel-fatture-in-cloud-v2.svg?style=flat-square)](https://packagist.org/packages/offline-agency/laravel-fatture-in-cloud-v2)
[![Tests](https://img.shields.io/github/actions/workflow/status/offline-agency/laravel-fatture-in-cloud-v2/main.yml?branch=main&label=tests&style=flat-square)](https://github.com/offline-agency/laravel-fatture-in-cloud-v2/actions/workflows/main.yml)
[![Coverage](https://img.shields.io/codecov/c/github/offline-agency/laravel-fatture-in-cloud-v2/main?style=flat-square)](https://codecov.io/gh/offline-agency/laravel-fatture-in-cloud-v2)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-level%209-brightgreen?style=flat-square)](phpstan.neon)
[![PHP Version](https://img.shields.io/packagist/dependency-v/offline-agency/laravel-fatture-in-cloud-v2/php?style=flat-square)](composer.json)
[![Laravel](https://img.shields.io/badge/Laravel-12%20%7C%2013-FF2D20?style=flat-square&logo=laravel&logoColor=white)](composer.json)
[![Total Downloads](https://img.shields.io/packagist/dt/offline-agency/laravel-fatture-in-cloud-v2.svg?style=flat-square)](https://packagist.org/packages/offline-agency/laravel-fatture-in-cloud-v2)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

**A Laravel SDK for the [Fatture in Cloud](https://www.fattureincloud.it/) API v2.** Create and send invoices, manage e-invoicing (fatturazione elettronica / SDI), clients, suppliers, products, receipts and more, with typed entities, a fluent facade and built-in handling of API rate limits.

> 🇮🇹 Pacchetto Laravel per integrare le API v2 di Fatture in Cloud: fatture, fatturazione elettronica, clienti, fornitori, prodotti, corrispettivi e altro.

```php
use OfflineAgency\LaravelFattureInCloudV2\Enums\IssuedDocumentType;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade as FIC;

$invoices = FIC::issuedDocuments()->all(IssuedDocumentType::Invoice); // every page, as typed entities

foreach ($invoices as $invoice) {
    echo $invoice->number.' - '.$invoice->amountGross;
}
```

## Why this package

- **Laravel-native.** Built on Laravel's HTTP client, so `Http::fake()` works in your tests. Config file, facade, container bindings and Artisan commands included.
- **Typed, readonly entities.** Responses are mapped to strictly typed PHP objects, not raw arrays. The codebase passes PHPStan at level 9.
- **Every page in one call.** `all()` follows the API's pagination for you; `list()` gives you a page plus navigation helpers.
- **Rate limits handled.** HTTP 429 responses are retried using the API's `Retry-After` header, with a cap so a worker is never blocked for long.
- **Multiple companies.** Configure several Fatture in Cloud companies and switch at runtime with `forCompany()`.
- **AI-assistant ready.** Ships [Laravel Boost](https://laravel.com/docs/boost) guidelines and an e-invoicing skill, so AI coding assistants write correct code for this package.
- **Broad API coverage.** 20 resource groups of the API v2, from issued documents and e-invoices to webhooks (see [API coverage](#api-coverage)).

## Requirements

| PHP | Laravel 12 | Laravel 13 |
|-----|:----------:|:----------:|
| 8.4 | ✅ | ✅ |
| 8.5 | ✅ | ✅ |
| 8.6 | ✅¹ | ✅ |

¹ Installs and runs, but isn't in the CI matrix: Laravel 12's test tooling (Pest 4 / paratest) doesn't support PHP 8.6 yet.

On Laravel 11? Composer installs 3.0.x automatically. For older PHP or Laravel versions, see the 2.x requirements in [UPGRADE.md](UPGRADE.md).

## Installation

```bash
composer require offline-agency/laravel-fatture-in-cloud-v2
```

Add your company ID and access token to `.env`. You can create a token in Fatture in Cloud following the [manual authentication guide](https://developers.fattureincloud.it/docs/authentication/manual-authentication/):

```dotenv
FCV2_DEFAULT_ID=123456
FCV2_DEFAULT_BEARER=a/your-access-token
```

Check that everything works:

```bash
php artisan fic:test-connection
```

Optionally publish the config file to `config/fatture-in-cloud-v2.php`:

```bash
php artisan vendor:publish --provider="OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2ServiceProvider"
```

## Usage

Access every API resource through the facade:

```php
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade as FIC;

$client = FIC::clients()->detail(42);

$invoice = FIC::issuedDocuments()->create([
    'data' => [
        'type' => 'invoice',
        'entity' => ['name' => 'Mario Rossi S.r.l.'],
        'date' => now(), // Carbon/DateTime or any parseable string, sent as Y-m-d
        'items_list' => [
            ['name' => 'Consulting', 'qty' => 1, 'net_price' => 500],
        ],
    ],
]);
```

The request body follows the [Fatture in Cloud API reference](https://developers.fattureincloud.it/api-reference).

You can also inject the manager or instantiate API classes directly:

```php
use OfflineAgency\LaravelFattureInCloudV2\Contracts\FattureInCloudManagerInterface;

public function __construct(private FattureInCloudManagerInterface $fic) {}

$this->fic->products()->list(['per_page' => 50]);

// or
$products = (new \OfflineAgency\LaravelFattureInCloudV2\Api\Product())->list();
```

### Handling errors

Methods return the entity on success. They don't throw on API errors; instead they return:

- an `Entities\Error` when the API answers with an error (4xx/5xx), with the API payload in `$error->error`;
- an `Illuminate\Support\MessageBag` when the request body fails local validation, before anything is sent.

```php
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use Illuminate\Support\MessageBag;

$result = FIC::clients()->create(['data' => ['name' => 'ACME']]);

if ($result instanceof MessageBag) {
    // invalid input, nothing was sent
} elseif ($result instanceof Error) {
    // API error, e.g. $result->error->message
} else {
    // $result is a typed Client entity
}
```

Configuration problems (an unknown company name, or a missing company ID or token) throw an `Exceptions\ConfigurationException` with a message telling you what to set, before any request is sent.

### Pagination

`all()` returns every result across all pages. `list()` returns one page with navigation helpers:

```php
$page = FIC::issuedDocuments()->list(IssuedDocumentType::Invoice, ['per_page' => 50]);

$page->getItems();                         // invoices on this page
$page->getPagination()->hasNextPage();     // bool
$next = $page->getPagination()->goToNextPage();
// also: hasPrevPage(), goToPrevPage(), goToFirstPage(), goToLastPage(), isSinglePage()
```

### Multiple companies

```php
// config/fatture-in-cloud-v2.php
'companies' => [
    'default' => ['id' => env('FCV2_DEFAULT_ID'), 'bearer' => env('FCV2_DEFAULT_BEARER')],
    'acme'    => ['id' => env('FCV2_ACME_ID'),    'bearer' => env('FCV2_ACME_BEARER')],
],
```

```php
$acmeClients = FIC::forCompany('acme')->clients()->list();
```

Have a token from somewhere else (for example an OAuth2 flow)? Pass it directly:

```php
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloud;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloudManager;

$fic = new FattureInCloudManager(new FattureInCloud(companyId: '123456', accessToken: $token));
```

### Enums

String-backed enums are available for document types. Plain strings (`'invoice'`, `'expense'`) still work.

```php
use OfflineAgency\LaravelFattureInCloudV2\Enums\IssuedDocumentType;
use OfflineAgency\LaravelFattureInCloudV2\Enums\ReceivedDocumentType;

FIC::issuedDocuments()->list(IssuedDocumentType::CreditNote);
FIC::receivedDocuments()->list(ReceivedDocumentType::Expense);
```

### Deleted documents

`bin()` returns a deleted issued document. This is useful, for example, after converting a proforma into an invoice, which deletes the proforma:

```php
$proforma = FIC::issuedDocuments()->bin($documentId);
```

### Rate limits

Fatture in Cloud allows [300 requests every 5 minutes per company, plus hourly and monthly quotas](https://developers.fattureincloud.it/docs/basics/limits-and-quotas/).

- **429 (short-term limit)** is retried automatically. The package waits for the time in the `Retry-After` header, or uses an exponential backoff when the header is missing.
- If the required wait is longer than `max_wait`, the error is returned immediately instead of blocking your request or queue worker.
- **403** is never retried: it means a missing permission, an expired license or an exhausted hourly/monthly quota.

```php
'limits' => [
    'max_retries' => 3,      // total attempts, including the first one
    'retry_delay' => 1000,   // ms, doubled on each attempt
    'max_wait' => 60000,     // ms, longest single wait allowed
],
```

### Artisan commands

```bash
php artisan fic:test-connection              # check credentials for the default company
php artisan fic:test-connection --company=acme
php artisan fic:api-status                   # list every API resource and method
```

## AI assistants (Laravel Boost)

If your app uses [Laravel Boost](https://laravel.com/docs/boost), run `php artisan boost:install` (or `boost:update` if Boost is already installed). Boost picks up this package's resources:

- **Guideline** (`resources/boost/guidelines/core.blade.php`): always loaded; covers the facade, result types, companies, rate limits and testing.
- **Skill** `fatture-in-cloud-e-invoicing`: loaded when relevant; walks through creating an invoice, previewing totals, verifying the XML, sending it to SDI and tracking its status.

Both are tested: their code examples run against a faked API in this package's test suite.

## Testing your application

Requests go through Laravel's HTTP client, so you can fake the API in your own tests. Set fake credentials first: without them a `ConfigurationException` is thrown before the request reaches the fake.

```php
use Illuminate\Support\Facades\Http;

config([
    'fatture-in-cloud-v2.companies.default.id' => '1',
    'fatture-in-cloud-v2.companies.default.bearer' => 'test-token',
]);

Http::fake([
    'api-v2.fattureincloud.it/c/*/entities/clients*' => Http::response([
        'data' => [['id' => 1, 'name' => 'ACME']],
    ]),
]);

$clients = FIC::clients()->all();
```

## API coverage

| Resource | Facade accessor | Resource | Facade accessor |
|---|---|---|---|
| User | `users()` | Receipts | `receipts()` |
| Companies | `company()` | Taxes (F24) | `taxes()` |
| Clients | `clients()` | Archive | `archive()` |
| Suppliers | `suppliers()` | Cashbook | `cashbook()` |
| Products & stock | `products()` | Info | `info()` |
| Issued documents | `issuedDocuments()` | Price lists | `priceLists()` |
| Issued e-invoices | `issuedEInvoices()` | Webhooks | `webhooks()` |
| Received documents | `receivedDocuments()` | Situation | `situation()` |
| Emails | `emails()` | VAT types | `vatTypes()` |
| Payment accounts | `paymentAccounts()` | Payment methods | `paymentMethods()` |

Run `php artisan fic:api-status` for the full list of methods.

## FAQ

**Is this the official SDK?**
No. Fatture in Cloud publishes [`fattureincloud/fattureincloud-php-sdk`](https://github.com/fattureincloud/fattureincloud-php-sdk), a framework-agnostic SDK generated from their OpenAPI spec, with OAuth2 helpers. This package is a Laravel integration: facade, config, container bindings, `Http::fake()` support, auto-pagination and rate-limit handling.

**Does it support OAuth2?**
The package authenticates with an access token per company. Tokens created via [manual authentication](https://developers.fattureincloud.it/docs/authentication/manual-authentication/) work out of the box. If you run your own OAuth2 flow, pass the resulting token to `new FattureInCloud(companyId: ..., accessToken: ...)`.

**Why is it called "v2" if the package is at version 3?**
"v2" refers to version 2 of the Fatture in Cloud API. The v1 API package is [`offline-agency/laravel-fatture-in-cloud`](https://github.com/offline-agency/laravel-fatture-in-cloud) and is no longer maintained.

**Why are entity properties camelCase?**
Since 3.0, entities use camelCase (`amountGross`, `createdAt`). See [UPGRADE.md](UPGRADE.md) for the full mapping from 2.x.

## Upgrading

See [UPGRADE.md](UPGRADE.md) and the [CHANGELOG](CHANGELOG.md).

## Contributing

Contributions are welcome. See [CONTRIBUTING](CONTRIBUTING.md); `composer check` runs Pint, PHPStan and the test suite.

## Security

Please report vulnerabilities privately as described in the [security policy](.github/SECURITY.md).

## Credits

- [Offline Agency](https://github.com/offline-agency)
- [Giacomo Fabbian](https://github.com/Giacomo92)
- [Nicolas Sanavia](https://github.com/SanaviaNicolas)
- [All contributors](https://github.com/offline-agency/laravel-fatture-in-cloud-v2/graphs/contributors)

Offline Agency is a web agency based in Padua, Italy. See our projects [on our website](https://offlineagency.it/).

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.
