# Changelog

All notable changes to `laravel-fatture-in-cloud-v2` will be documented in this file.

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
