# Laravel Fatture in Cloud v2

[![Latest Stable Version](https://poser.pugx.org/offline-agency/laravel-fatture-in-cloud-v2/v/stable)](https://packagist.org/packages/offline-agency/laravel-fatture-in-cloud-v2)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Laravel](https://github.com/offline-agency/laravel-fatture-in-cloud-v2/actions/workflows/main.yml/badge.svg?branch=master)](https://github.com/offline-agency/laravel-fatture-in-cloud-v2/actions/workflows/main.yml)
[![StyleCI](https://github.styleci.io/repos/470182449/shield)](https://styleci.io/repos/470182449)
[![Total Downloads](https://img.shields.io/packagist/dt/offline-agency/laravel-fatture-in-cloud-v2.svg?style=flat-square)](https://packagist.org/packages/offline-agency/laravel-fatture-in-cloud-v2)

![Laravel Fatture in Cloud v2](https://banners.beyondco.de/Laravel%20Fatture%20in%20Cloud%20v2.png?theme=dark&packageManager=composer+require&packageName=offline-agency%2Flaravel-fatture-in-cloud-v2&pattern=autumn&style=style_1&description=A+simple+laravel+integration+with+Fatture+in+Cloud+APIs+v2&md=1&showWatermark=0&fontSize=100px&images=currency-euro&widths=200)

🔙 This is the documentation for the API v2. You can find the package for the API v1 [here](https://docs.offlineagency.com/laravel-fatture-in-cloud/#laravel-fatture-in-cloud).

## Documentation, Installation, and Usage Instructions
See the [documentation](https://docs.offlineagency.com/laravel-fatture-in-cloud-v2/) for detailed installation and usage instructions.

## What It Does

This package provides a simple Laravel integration with [Fatture in Cloud APIs v2](https://developers.fattureincloud.it/). Let's see some example:

``` php
$issued_documents = new \OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument();
$issued_document_list = $issued_document->list('invoice', [
    'per_page' => 50
]);  

// return an array of invoices 
$issued_document_list->getItems();

// return pagination fields like page, per_page...
$issued_document_list->getPagination();

// return single product's fields
$product = new \OfflineAgency\LaravelFattureInCloudV2\Api\Product();
$product_detail = $product->detail($product_id);
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
This package provides a method to intercept throttle errors (403, 429) and automatically retry.
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

🔜 Issued e-invoices

❌ Received Documents

✅ Receipts

❌ Taxes

❌ Archive

❌ Cashbook

🔜 Info

❌ Settings

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email <support@offlineagency.com> instead of using the issue
tracker.

## Credits

- [Offline Agency](https://github.com/offline-agency)
- [Giacomo Fabbian](https://github.com/Giacomo92)
- [Nicolas Sanavia](https://github.com/SanaviaNicolas)
- [All Contributors](../../contributors)

## About us

Offline Agency is a web design agency based in Padua, Italy. You'll find an overview of our
projects [on our website](https://offlineagency.it/).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
