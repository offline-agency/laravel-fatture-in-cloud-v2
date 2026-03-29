# Changelog

All notable changes to `laravel-fatture-in-cloud-v2` will be documented in this file.

## [3.1.0] - YYYY-MM-DD

### Added
- Support for **Laravel 13** (illuminate `^13.0`, Testbench `^11.0`).
- Laravel 13 row in CI matrix (PHP 8.4/8.5).

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

## [2.0.0] - 2026-02-05

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

## [1.0.0] - 2021-01-01

- Initial release with support for Fatture in Cloud API v2.
