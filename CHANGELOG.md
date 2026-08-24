# Changelog

All notable changes to `laravel-fatture-in-cloud-v2` will be documented in this file.

## [4.0.0] - YYYY-MM-DD

### Added
- Support for **Laravel 13** (illuminate `^13.0`, Testbench `^11.0`).

### Changed
- **BREAKING**: Minimum PHP bumped to **8.5** (`php: ^8.5`).
- **BREAKING**: Dropped support for **Laravel 11 and 12**; the package now requires `illuminate/* ^13.0` and `orchestra/testbench ^11.0`.
- **BREAKING**: Test suite upgraded to **Pest `^5.0`**, which requires **PHPUnit `^13.3`**. Because Testbench 9 (Laravel 11) caps PHPUnit at 12, Laravel 11 could not be kept.
- CI matrix reduced to a single job (PHP 8.5 / Laravel 13); Pint and PHPStan now run unconditionally.
- `phpunit.xml` now references the PHPUnit 13.3 schema.
- `pint.json`: renamed the deprecated `new_with_braces` rule to `new_with_parentheses` (Pint `^1.30`), preserving the existing `new Foo()` style.

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
