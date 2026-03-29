<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2;

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
use OfflineAgency\LaravelFattureInCloudV2\Contracts\ConnectorInterface;
use OfflineAgency\LaravelFattureInCloudV2\Contracts\FattureInCloudManagerInterface;

class FattureInCloudManager implements FattureInCloudManagerInterface
{
    protected ConnectorInterface $connector;

    public function __construct(?ConnectorInterface $connector = null)
    {
        $this->connector = $connector ?? new FattureInCloud();
    }

    public function forCompany(?string $companyName): static
    {
        $clone = clone $this;
        $clone->connector = new FattureInCloud(companyName: $companyName);

        return $clone;
    }

    public function getConnector(): ConnectorInterface
    {
        return $this->connector;
    }

    public function archive(): Archive
    {
        return new Archive($this->connector);
    }

    public function cashbook(): Cashbook
    {
        return new Cashbook($this->connector);
    }

    public function clients(): Client
    {
        return new Client($this->connector);
    }

    public function company(): Company
    {
        return new Company($this->connector);
    }

    public function emails(): Email
    {
        return new Email($this->connector);
    }

    public function info(): Info
    {
        return new Info($this->connector);
    }

    public function issuedDocuments(): IssuedDocument
    {
        return new IssuedDocument($this->connector);
    }

    public function issuedEInvoices(): IssuedEInvoice
    {
        return new IssuedEInvoice($this->connector);
    }

    public function paymentAccounts(): PaymentAccount
    {
        return new PaymentAccount($this->connector);
    }

    public function paymentMethods(): PaymentMethod
    {
        return new PaymentMethod($this->connector);
    }

    public function priceLists(): PriceList
    {
        return new PriceList($this->connector);
    }

    public function products(): Product
    {
        return new Product($this->connector);
    }

    public function receipts(): Receipt
    {
        return new Receipt($this->connector);
    }

    public function receivedDocuments(): ReceivedDocument
    {
        return new ReceivedDocument($this->connector);
    }

    public function situation(): Situation
    {
        return new Situation($this->connector);
    }

    public function suppliers(): Supplier
    {
        return new Supplier($this->connector);
    }

    public function taxes(): Taxes
    {
        return new Taxes($this->connector);
    }

    public function users(): User
    {
        return new User($this->connector);
    }

    public function vatTypes(): VatType
    {
        return new VatType($this->connector);
    }

    public function webhooks(): Webhook
    {
        return new Webhook($this->connector);
    }
}
