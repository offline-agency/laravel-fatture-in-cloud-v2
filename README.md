# Laravel Fatture in Cloud v2

[![Latest Stable Version](https://poser.pugx.org/offline-agency/laravel-fatture-in-cloud-v2/v/stable)](https://packagist.org/packages/offline-agency/laravel-fatture-in-cloud-v2)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![run-tests](https://github.com/offline-agency/laravel-fatture-in-cloud-v2/actions/workflows/main.yml/badge.svg)](https://github.com/offline-agency/laravel-fatture-in-cloud-v2/actions/workflows/main.yml)
[![codecov](https://codecov.io/gh/offline-agency/laravel-fatture-in-cloud-v2/branch/master/graph/badge.svg?token=02NPUBvT9i)](https://codecov.io/gh/offline-agency/laravel-fatture-in-cloud-v2)
[![Laravel Pint](https://img.shields.io/badge/code%20style-pint-orange)](https://github.com/laravel/pint)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](https://phpstan.org/)
[![Total Downloads](https://img.shields.io/packagist/dt/offline-agency/laravel-fatture-in-cloud-v2.svg?style=flat-square)](https://packagist.org/packages/offline-agency/laravel-fatture-in-cloud-v2)
![Laravel Fatture in Cloud v2](https://banners.beyondco.de/Laravel%20Fatture%20in%20Cloud%20v2.png?theme=dark&packageManager=composer+require&packageName=offline-agency%2Flaravel-fatture-in-cloud-v2&pattern=autumn&style=style_1&description=A+simple+laravel+integration+with+Fatture+in+Cloud+APIs+v2&md=1&showWatermark=0&fontSize=100px&images=currency-euro&widths=200)

🔙 This is the documentation for the API v2. You can find the package for the API v1 [here](https://docs.offlineagency.com/laravel-fatture-in-cloud/#laravel-fatture-in-cloud).

### Warning for integrators

- **Keep your copy up to date:** Check the [official laravel-fatture-in-cloud-v2](https://github.com/offline-agency/laravel-fatture-in-cloud-v2) package and update your local dependency (e.g. run `composer update offline-agency/laravel-fatture-in-cloud-v2` or pull the latest from the repository).
- **Response variables are camelCase:** Entity properties use **camelCase** (e.g. `amountGross`, `amountNet`, `amountVat`), not snake_case (`amount_gross`, `amount_net`, `amount_vat`). If you have existing code that reads response data, update it to use the new property names. Use the entity classes in this package as the reference—for example, [`IssuedDocument`](src/Entities/IssuedDocument/IssuedDocument.php) for issued documents. Examples: `amount_gross` → `amountGross`, `amount_net` → `amountNet`, `created_at` → `createdAt`.
- **Config:** Check the package config [`config/fatture-in-cloud-v2.php`](config/fatture-in-cloud-v2.php) and update your project’s config to match, especially **`baseUrl`**. Use the root API URL only (no extra path segments).

## Requirements

- PHP ^8.4 (includes 8.5)
- Laravel ^11.0|^12.0|^13.0

| PHP | Laravel 11 | Laravel 12 | Laravel 13 |
|-----|:----------:|:----------:|:----------:|
| 8.4 | ✅ | ✅ | ✅ |
| 8.5 | ✅ | ✅ | ✅ |

### API Granularization (Breaking Changes)
The monolithic `Settings` and `Setting` classes have been split into granular resources to improve maintainability and strictly follow the Single Responsibility Principle:
- `Settings` -> Split into `VatType`, `PaymentAccount`, and `PaymentMethod`.
- `ArchiveDocument` -> Renamed to `Archive`.
- `Cashbooks` -> Renamed to `Cashbook`.
- New classes added: `Email`, `Situation`, `PriceList`, and `Webhook`.

### Strictly Typed & Readonly Entities
All entities (e.g., `Client`, `IssuedDocument`, `PriceList`) have been refactored to be **readonly** classes with **strict types**.
- Properties are now immutable.
- Usage of `mixed` types has been minimized in favor of strict `string`, `int`, `float`, `bool`, etc.
- Constructors ensure safe data mapping from API responses.

### Modern testing suite
- Switched from PHPUnit to **Pest PHP** for a more expressive and modern testing experience.
- Automated code styling with **Laravel Pint**.

### Architecture
- The package now utilizes a central `FattureInCloud` connector for better state management.
- API interactions are handled via the native Laravel `Http` client.

## Quick Start

This package provides a simple Laravel integration with [Fatture in Cloud APIs v2](https://developers.fattureincloud.it/).

See the [documentation](https://docs.offlineagency.com/laravel-fatture-in-cloud-v2/) for detailed installation and usage instructions.

```php
// 1. Via Facade (recommended)
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade as FIC;
use OfflineAgency\LaravelFattureInCloudV2\Enums\IssuedDocumentType;

$clients = FIC::clients()->list();
$invoices = FIC::issuedDocuments()->list(IssuedDocumentType::Invoice);

// 2. Via Dependency Injection
use OfflineAgency\LaravelFattureInCloudV2\Contracts\FattureInCloudManagerInterface;

public function __construct(private FattureInCloudManagerInterface $fic) {}
$this->fic->issuedDocuments()->list(IssuedDocumentType::Invoice);

// 3. Direct instantiation (still works)
$api = new \OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument();
$list = $api->list('invoice', ['per_page' => 50]);
$list->getItems();       // array of invoices
$list->getPagination();  // pagination fields
```

## Multi-Company

Configure multiple companies in `config/fatture-in-cloud-v2.php`:

```php
'companies' => [
    'default' => ['id' => env('FCV2_DEFAULT_ID'), 'bearer' => env('FCV2_DEFAULT_BEARER')],
    'acme'    => ['id' => env('FCV2_ACME_ID'),    'bearer' => env('FCV2_ACME_BEARER')],
],
```

Switch at runtime:

```php
$acmeClients = FIC::forCompany('acme')->clients()->list();
```

## Enums

String-backed PHP enums are available for document types:

```php
use OfflineAgency\LaravelFattureInCloudV2\Enums\IssuedDocumentType;
use OfflineAgency\LaravelFattureInCloudV2\Enums\ReceivedDocumentType;
use OfflineAgency\LaravelFattureInCloudV2\Enums\ReceiptType;

$invoices = FIC::issuedDocuments()->list(IssuedDocumentType::Invoice);
$expenses = FIC::receivedDocuments()->list(ReceivedDocumentType::Expense);
```

Backward compatible: string values (`'invoice'`, `'expense'`) still accepted.

## Artisan Commands

```bash
# Test API connection (accepts --company=name)
php artisan fic:test-connection
php artisan fic:test-connection --company=acme

# List all API resources and methods
php artisan fic:api-status
```

## Features

### All [![HOT](https://img.shields.io/static/v1.svg?label=&message=HOT&color=red)]()
This package provide `all()` method that allow you to get an array of all results without pagination. It's implemented for all endpoint that provide a list method with pagination. Let's see an example:

```php
$issued_documents = new \OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument();
$issued_document_list = $issued_documents->all('invoice');
```

### Pagination
This package provides a pagination system that allow you to move between pages using simple methods:

```php
$issued_documents = new \OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument();
$issued_document_list = $issued_documents->list('invoice');

// check if the response has more than one page
$issued_document_list->getPagination()->isSinglePage();

// check if the document has a next page
$issued_document_list->getPagination()->hasNextPage();

// check if the document has a previous page
$issued_document_list->getPagination()->hasPrevPage();

// return documents of the next page
$issued_document_list->getPagination()->goToNextPage();

// return documents of the previous page
$issued_document_list->getPagination()->goToPrevPage();

// return documents of the first page
$issued_document_list->getPagination()->goToFirstPage();

// return documents of the last page
$issued_document_list->getPagination()->goToLastPage();
```

### Bin [![HOT](https://img.shields.io/static/v1.svg?label=&message=HOT&color=red)]()
This package provides bin() method for deleted issued documents that allow you to get its detail. This is very useful, for example, when you convert a
proforma into an invoice (deleting the proforma) and you need old document's detail. Let's see an example:

```php
$issued_documents = new \OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument();
$response = $issued_documents->bin($document_id);
```

### Rate limit [![HOT](https://img.shields.io/static/v1.svg?label=&message=HOT&color=red)]()
This     package provides a method to intercept throttle errors (403, 429) and automatically retry.
You can specify limits on your config, remember to use milliseconds to indicate time:

```php
'limits' => [
    'default' => 300000,
    '403' => 300000,
    '429' => 3600000,
],
```

## API coverage

We are currently work on this package to implement all endpoints. Enable notifications to be notified when new API are released.

✅ User

✅ Companies

✅ Clients

✅ Suppliers

✅ Products

✅ Issued Documents

✅ Issued e-invoices

✅ Received Documents

✅ Receipts

✅ Taxes

✅ Archive

✅ Cashbook

✅ Info

✅ Price Lists

✅ Webhooks

✅ Situation

✅ Emails

✅ Stock

✅ Payment Accounts

✅ Payment Methods

✅ VAT Types

## Testing

```bash
composer test
```

Unit and Feature tests use mocked HTTP. To run **integration tests** (real HTTP calls to Fatture in Cloud), set in `.env`:

- `FCV2_DEFAULT_ID` – company ID
- `FCV2_DEFAULT_BEARER` – API bearer token

Then run:

```bash
php vendor/bin/pest tests/Integration
```

If these env vars are not set, integration tests are skipped.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email <support@offlineagency.com> instead of using the issue
tracker.

## Credits

- [Offline Agency](https://github.com/offline-agency)
- [Giacomo Fabbian](https://github.com/Giacomo92)
- [Nicolas Sanavia](https://github.com/SanaviaNicolas)
- [All Contributors](https://github.com/offline-agency/laravel-fatture-in-cloud-v2/graphs/contributors)

## About us

Offline Agency is a web design agency based in Padua, Italy. You'll find an overview of our
projects [on our website](https://offlineagency.it/).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
