<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2;

use Illuminate\Support\Facades\Facade;
use OfflineAgency\LaravelFattureInCloudV2\Api\Archive;
use OfflineAgency\LaravelFattureInCloudV2\Api\Cashbook;
use OfflineAgency\LaravelFattureInCloudV2\Api\Client;
use OfflineAgency\LaravelFattureInCloudV2\Api\Company;
use OfflineAgency\LaravelFattureInCloudV2\Api\Email;
use OfflineAgency\LaravelFattureInCloudV2\Api\Info;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedEInvoice;
use OfflineAgency\LaravelFattureInCloudV2\Api\PaymentAccount;
use OfflineAgency\LaravelFattureInCloudV2\Api\PaymentMethod;
use OfflineAgency\LaravelFattureInCloudV2\Api\PriceList;
use OfflineAgency\LaravelFattureInCloudV2\Api\Product;
use OfflineAgency\LaravelFattureInCloudV2\Api\Receipt;
use OfflineAgency\LaravelFattureInCloudV2\Api\ReceivedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Api\Situation;
use OfflineAgency\LaravelFattureInCloudV2\Api\Supplier;
use OfflineAgency\LaravelFattureInCloudV2\Api\Taxes;
use OfflineAgency\LaravelFattureInCloudV2\Api\User;
use OfflineAgency\LaravelFattureInCloudV2\Api\VatType;
use OfflineAgency\LaravelFattureInCloudV2\Api\Webhook;

/**
 * @method static FattureInCloudManager forCompany(?string $companyName)
 * @method static Archive archive()
 * @method static Cashbook cashbook()
 * @method static Client clients()
 * @method static Company company()
 * @method static Email emails()
 * @method static Info info()
 * @method static IssuedDocument issuedDocuments()
 * @method static IssuedEInvoice issuedEInvoices()
 * @method static PaymentAccount paymentAccounts()
 * @method static PaymentMethod paymentMethods()
 * @method static PriceList priceLists()
 * @method static Product products()
 * @method static Receipt receipts()
 * @method static ReceivedDocument receivedDocuments()
 * @method static Situation situation()
 * @method static Supplier suppliers()
 * @method static Taxes taxes()
 * @method static User users()
 * @method static VatType vatTypes()
 * @method static Webhook webhooks()
 *
 * @see FattureInCloudManager
 */
class LaravelFattureInCloudV2Facade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-fatture-in-cloud-v2';
    }
}
