<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Contracts;

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

interface FattureInCloudManagerInterface
{
    public function forCompany(?string $companyName): static;

    public function getConnector(): ConnectorInterface;

    public function archive(): Archive;

    public function cashbook(): Cashbook;

    public function clients(): Client;

    public function company(): Company;

    public function emails(): Email;

    public function info(): Info;

    public function issuedDocuments(): IssuedDocument;

    public function issuedEInvoices(): IssuedEInvoice;

    public function paymentAccounts(): PaymentAccount;

    public function paymentMethods(): PaymentMethod;

    public function priceLists(): PriceList;

    public function products(): Product;

    public function receipts(): Receipt;

    public function receivedDocuments(): ReceivedDocument;

    public function situation(): Situation;

    public function suppliers(): Supplier;

    public function taxes(): Taxes;

    public function users(): User;

    public function vatTypes(): VatType;

    public function webhooks(): Webhook;
}
