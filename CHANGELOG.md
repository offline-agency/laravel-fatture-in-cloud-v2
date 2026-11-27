# Changelog

All notable changes to `laravel-fatture-in-cloud-v2` will be documented in this file.

## [3.1.0] - YYYY-MM-DD

### Added
- Support for **PHP 8.6**; CI matrix now covers PHP 8.4/8.5/8.6 × Laravel 12/13, plus a `prefer-lowest` job.
- `ConfigurationException`, thrown for an unknown company name or a missing company ID / access token, with a message saying what to set.
- Rate-limit handling honours the `Retry-After` header (seconds or HTTP date), with a `max_wait` cap.
- Attachment uploads accept a stream resource or a file (`SplFileInfo` / `UploadedFile`) as well as a string; unsupported values throw `InvalidArgumentException`.
- Connector methods `getCompanyId()`, `getAccessToken()`, `getBaseUrl()` and `getRequest()` on `FattureInCloudManager` and the facade, keeping 3.0 facade calls working.
- **Laravel Boost** resources for AI coding assistants: a guideline (`resources/boost/guidelines/core.blade.php`) and an e-invoicing skill (`resources/boost/skills/fatture-in-cloud-e-invoicing`). Their code examples run in the test suite.
- `llms.txt` describing the package for LLMs and AI search.
- **100% test coverage** (lines, methods, classes), enforced in CI and by `composer test:coverage`.
- `ConnectorInterface` and `FattureInCloudManagerInterface` contracts.
- `FattureInCloudManager` with fluent API access via Facade.
- `forCompany()` method for runtime multi-company switching.
- PHP string-backed enums: `IssuedDocumentType`, `ReceivedDocumentType`, `ReceiptType`.
- `fic:test-connection` Artisan command to verify API auth.
- `fic:api-status` Artisan command listing all API resources and methods.
- Pest architecture tests (strict_types, readonly entities, API inheritance, no debug functions).
- `covers()` annotations on all test files.
- `ApiResponse` DTO replacing untyped object returns.
- Composer `check` script (format + analyse + test).
- Dedicated CI `static-analysis` job.

### Changed
- **PHPStan upgraded from level 6 to level 9** with zero `ignoreErrors`.
- Facade now resolves to `FattureInCloudManager` (was raw `FattureInCloud` connector).
- API throttle handler: bounded retry with exponential backoff (was infinite recursion). Only 429 is retried; 403 (missing scope, expired license, exhausted quota) is returned immediately.
- `limits` config: new keys `max_retries`, `retry_delay`, `max_wait`, all in milliseconds. The old `default`, `403` and `429` keys are ignored. See UPGRADE.md.
- Test suite runs on Pest 4 (Laravel 12) or Pest 5 (Laravel 13).
- README rewritten: installation, error handling, rate limits, testing with `Http::fake()`, FAQ.
- `composer.json` metadata: description, keywords, `support` and `funding`.
- `composer.lock` is no longer committed (this is a library).
- Community files: code of conduct, issue and PR templates, Dependabot for GitHub Actions, supported versions in the security policy.
- `Api` constructor accepts `ConnectorInterface` (was concrete `FattureInCloud`).
- Complete Pest migration: `beforeEach()`, `dataset()` consolidation.
- Removed redundant `phpunit/phpunit` from require-dev.
- Renamed `phpunit.xml` to `phpunit.xml.dist`.
- Legacy entity list classes refactored to readonly with constructor-only assignment.

### Removed
- **Laravel 11 support.** It is end of life and every 11.x release has open security advisories. Laravel 11 users stay on 3.0.x.

### Deprecated
- Twelve entity classes not returned by any API method (`Entities\Info\ArchiveCategories`, `CostCenters`, `PaymentAccounts`, `PaymentMethods`, `ProductsCategories`, `ReceivedDocumentCategories`, `RevenueCenters`; `Entities\Settings\PaymentMethods`, `SettingsCreate`, `SettingsCreateVatType`, `SettingsGetVatType`; `Entities\Taxes\TaxesCreate`). They will be removed in 4.0.
- `LaravelFattureInCloudV2` class — use `FattureInCloud` instead.
- `DOCUMENT_TYPES` / `RECEIPT_TYPES` constants — use enums instead.

### Fixed
- Infinite retry loop in `Api::handleResponse()` on persistent 403/429.
- `$hasFile` parameter lost on retry in `post()` method.
- Removed duplicate `$company_id` property from `Api.php`.
- Rate-limit delays were passed to `usleep()` (microseconds) although documented as milliseconds.
- Attachment uploads sent the file twice (as a form field and as a file part).
- Attachment uploads sent an empty file when given anything other than a string; a stream was also re-sent empty when a 429 was retried.
- A malformed or huge `Retry-After` header could crash with a `TypeError` or cause a multi-hour wait.
- Requests with missing credentials or an unknown company were sent with empty values and failed with an opaque 401.
- Removed an unreachable `Y-n-j` branch in `NormalizesDatesTrait`.

## [3.0.1] - 2026-05-25

### Added
- Support for **Laravel 13** (illuminate `^13.0`, Testbench `^11.0`).

## [3.0.0] - 2026-03-28

### Added
- New API endpoint classes: `Email`, `Situation`, `PriceList`, and `Webhook`.
- Modern testing suite using **Pest PHP**.
- Code styling automation with **Laravel Pint**.
- Static analysis with **PHPStan** level 6.
- Support for **PHP 8.4/8.5** and **Laravel 11/12**.
- Integration test support with real HTTP calls (skipped when env vars are absent).
- 100% coverage for `FattureInCloud.php` connector.

### Changed
- **BREAKING**: Minimum PHP bumped to 8.4.
- **BREAKING**: Refactored API structure for better granularity:
    - `Settings` and `Setting` split into `VatType`, `PaymentAccount`, and `PaymentMethod`.
    - `ArchiveDocument` renamed to `Archive`.
    - `Cashbooks` renamed to `Cashbook`.
- **BREAKING**: All entities refactored to be **readonly** and **strictly typed**.
- Switched to native Laravel `Http` client for all API interactions.
- Central `FattureInCloud` connector for state management with improved safety checks.
- Improved `ListTrait` to prevent state pollution between successive `all()` calls.

### Fixed
- Validation bugs in `Archive` and `Client` creation/editing.
- Data mapping issues in fake responses.
- Correct `Info` endpoint URLs and `IssuedEInvoice` return type.
- Base URL path normalization.

## [2.1.3] - 2024-05-24

### Fixed
- E-invoice endpoint fixes.

## [2.1.2] - 2022-11-09

### Fixed
- `str_replace` method fix.

## [2.1.1] - 2022-10-26

### Fixed
- Avoid breaking changes in receipts methods.

## [2.1.0] - 2022-10-26

### Added
- `all()` method for suppliers, products, issued documents, clients.
- Receipts endpoint (full CRUD).
- Company endpoint.
- User endpoint.
- `binDetail()` method for issued documents.

### Fixed
- Base URL fix (removed `/c` prefix).

## [2.0.3] - 2022-10-24

### Added
- VAT types list.

## [2.0.2] - 2022-06-24

### Added
- `hasItems()` method for all lists.
- Supplier tests.
- `binDetail` for issued documents.

## [2.0.1] - 2022-06-22

### Fixed
- README fixes and documentation improvements.

## [2.0.0] - 2022-06-21

### Added
- New API endpoint classes: `Email`, `Situation`, `PriceList`, and `Webhook`.
- Modern testing suite using **Pest PHP**.
- Code styling automation with **Laravel Pint**.
- Support for **PHP 8.4** and **Laravel 12.0**.

### Changed
- **BREAKING**: Refactored API structure for better granularity:
    - `Settings` and `Setting` split into `VatType`, `PaymentAccount`, and `PaymentMethod`.
    - `ArchiveDocument` renamed to `Archive`.
    - `Cashbooks` renamed to `Cashbook`.
- **BREAKING**: Refactored all Entities to be **readonly** and **strictly typed**.
- Improved `FattureInCloud` connector for more robust connection handling.
- Switched to native Laravel `Http` client for all API interactions.

### Fixed
- Validation bugs in `Archive` and `Client` creation/editing.
- Data mapping issues in `ClientFakeResponse`.

## [1.2.0] - 2022-06-10

### Added
- Additional API coverage.

## [1.1.0] - 2022-06-09

### Added
- Additional features and improvements.

## [1.0.0] - 2021-01-01

- Initial release with support for Fatture in Cloud API v2.
