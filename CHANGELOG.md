# Changelog

All notable changes to `laravel-fatture-in-cloud-v2` will be documented in this file.

## [3.1.0] - YYYY-MM-DD

### Added
- Support for **Laravel 13** (illuminate `^13.0`, Testbench `^11.0`).
- Laravel 13 row in CI matrix (PHP 8.4/8.5).
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
- API throttle handler: bounded retry with exponential backoff (was infinite recursion).
- `Api` constructor accepts `ConnectorInterface` (was concrete `FattureInCloud`).
- Complete Pest migration: `beforeEach()`, `dataset()` consolidation.
- Removed redundant `phpunit/phpunit` from require-dev.
- Renamed `phpunit.xml` to `phpunit.xml.dist`.
- Legacy entity list classes refactored to readonly with constructor-only assignment.

### Deprecated
- `LaravelFattureInCloudV2` class — use `FattureInCloud` instead.
- `DOCUMENT_TYPES` / `RECEIPT_TYPES` constants — use enums instead.

### Fixed
- Infinite retry loop in `Api::handleResponse()` on persistent 403/429.
- `$hasFile` parameter lost on retry in `post()` method.
- Removed duplicate `$company_id` property from `Api.php`.

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
