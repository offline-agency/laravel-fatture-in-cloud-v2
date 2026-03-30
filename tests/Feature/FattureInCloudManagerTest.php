<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
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
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientList;
use OfflineAgency\LaravelFattureInCloudV2\FattureInCloudManager;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ClientFakeResponse;

describe('FattureInCloudManager', function () {
    beforeEach(function () {
        $this->manager = app(FattureInCloudManager::class);
    });

    it('resolves from container', function () {
        expect($this->manager)->toBeInstanceOf(FattureInCloudManager::class);
    });

    it('resolves via interface binding', function () {
        expect(app(FattureInCloudManagerInterface::class))->toBeInstanceOf(FattureInCloudManager::class);
    });

    it('getConnector returns ConnectorInterface', function () {
        expect($this->manager->getConnector())->toBeInstanceOf(ConnectorInterface::class);
    });

    it('forCompany returns a new instance', function () {
        config(['fatture-in-cloud-v2.companies.secondary' => ['id' => 'other_id', 'bearer' => 'other_bearer']]);
        $switched = $this->manager->forCompany('secondary');

        expect($switched)->toBeInstanceOf(FattureInCloudManager::class)
            ->and($switched)->not->toBe($this->manager)
            ->and($switched->getConnector()->getCompanyId())->toBe('other_id');
    });

    it('returns correct API class for each accessor', function (string $method, string $expectedClass) {
        expect($this->manager->{$method}())->toBeInstanceOf($expectedClass);
    })->with([
        'archive' => ['archive', Archive::class],
        'cashbook' => ['cashbook', Cashbook::class],
        'clients' => ['clients', Client::class],
        'company' => ['company', Company::class],
        'emails' => ['emails', Email::class],
        'info' => ['info', Info::class],
        'issuedDocuments' => ['issuedDocuments', IssuedDocument::class],
        'issuedEInvoices' => ['issuedEInvoices', IssuedEInvoice::class],
        'paymentAccounts' => ['paymentAccounts', PaymentAccount::class],
        'paymentMethods' => ['paymentMethods', PaymentMethod::class],
        'priceLists' => ['priceLists', PriceList::class],
        'products' => ['products', Product::class],
        'receipts' => ['receipts', Receipt::class],
        'receivedDocuments' => ['receivedDocuments', ReceivedDocument::class],
        'situation' => ['situation', Situation::class],
        'suppliers' => ['suppliers', Supplier::class],
        'taxes' => ['taxes', Taxes::class],
        'users' => ['users', User::class],
        'vatTypes' => ['vatTypes', VatType::class],
        'webhooks' => ['webhooks', Webhook::class],
    ]);

    it('makes API call through manager', function () {
        Http::fake([
            '*/entities/clients*' => Http::response(
                (new ClientFakeResponse())->getClientsFakeList()
            ),
        ]);

        $response = $this->manager->clients()->list();

        expect($response)->toBeInstanceOf(ClientList::class);
    });
})->covers(FattureInCloudManager::class);
