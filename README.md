# Laravel Fatture in Cloud v2

[![Latest Stable Version](https://poser.pugx.org/offline-agency/laravel-fatture-in-cloud-v2/v/stable)](https://packagist.org/packages/offline-agency/laravel-fatture-in-cloud-v2)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Laravel](https://github.com/offline-agency/laravel-fatture-in-cloud-v2/actions/workflows/main.yml/badge.svg?branch=master)](https://github.com/offline-agency/laravel-fatture-in-cloud-v2/actions/workflows/main.yml)
[![StyleCI](https://github.styleci.io/repos/167236902/shield)](https://styleci.io/repos/167236902)
[![Total Downloads](https://img.shields.io/packagist/dt/offline-agency/laravel-fatture-in-cloud-v2.svg?style=flat-square)](https://packagist.org/packages/offline-agency/laravel-fatture-in-cloud-v2)

A simple Laravel integration with Fatture in Cloud APIs v2.

![Laravel Fatture in Cloud v2](https://banners.beyondco.de/Laravel%20Fatture%20in%20Cloud%20v2.png?theme=dark&packageManager=composer+require&packageName=offline-agency%2Flaravel-fatture-in-cloud-v2&pattern=autumn&style=style_1&description=A+simple+laravel+integration+with+Fatture+in+Cloud+APIs+v2&md=1&showWatermark=0&fontSize=100px&images=currency-euro&widths=200)

## Installation

Install the package through [Composer](http://getcomposer.org/).

Run the Composer require command from the Terminal:

```bash
composer require offline-agency/laravel-fatture-in-cloud-v2
```

You should publish config file with:

```bash
php artisan vendor:publish --provider="Offlineagency\LaravelWebex\Providers\LaravelWebexServiceProvider"
```

Package provide multiple-companies handling. In your config you can provide more companies like that 
```php
... 

'companies' => [
    'default' => [
        'id' => env('FCV2_DEFAULT_ID', ''),
        'bearer' => env('FCV2_DEFAULT_BEARER', '')
    ],
    'first_company' => [
        'id' => env('FCV2_FIRST_COMPANY_ID', ''),
        'bearer' => env('FCV2_FIRST_COMPANY_BEARER', '')
    ],
    'second_company' => [
        'id' => env('FCV2_SECOND_COMPANY_ID', ''),
        'bearer' => env('FCV2_SECOND_COMPANY_BEARER', '')
    ]
]
```

Then you can specify (or not) a company on class initialization:
```php
// take the default
$issued_documents = new IssuedDocument();

// specify company
$issued_documents = new IssuedDocument('first_company');
```
## Usage

Each callback accept a number of parameters equals to the sum of the required parameters +1 that is $additional_data
that accept all optional parameters.

## Examples

### Issued documents
```php
$issued_documents = new IssuedDocument();
$response = $issued_documents->list($document_type);
```

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
