<?php

declare(strict_types=1);

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\ArchiveCategories;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\CostCenters;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\PaymentAccounts;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\PaymentMethods as InfoPaymentMethods;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\ProductsCategories;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\ReceivedDocumentCategories;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\RevenueCenters;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentMethods as SettingsPaymentMethods;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\SettingsCreate;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\SettingsCreateVatType;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\SettingsGetVatType;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\TaxesCreate;

/*
 * These entities are not returned by any API method and are deprecated (removal in 4.0).
 * The tests pin their mapping so they keep working for anyone instantiating them directly.
 */
describe('Deprecated entities', function () {
    it('maps API fields to camelCase properties', function (string $class, array $payload, array $expected) {
        $entity = new $class((object) $payload);

        foreach ($expected as $property => $value) {
            expect($entity->{$property})->toBe($value);
        }
    })->with([
        'Info\ArchiveCategories' => [ArchiveCategories::class, ['data' => 'Contracts'], ['data' => 'Contracts']],
        'Info\CostCenters' => [CostCenters::class, ['data' => 'Marketing'], ['data' => 'Marketing']],
        'Info\ProductsCategories' => [ProductsCategories::class, ['data' => 'Software'], ['data' => 'Software']],
        'Info\ReceivedDocumentCategories' => [ReceivedDocumentCategories::class, ['data' => 'Utilities'], ['data' => 'Utilities']],
        'Info\RevenueCenters' => [RevenueCenters::class, ['data' => 'Consulting'], ['data' => 'Consulting']],
        'Info\PaymentAccounts' => [PaymentAccounts::class, [
            'id' => 1, 'name' => 'Main account', 'type' => 'bank', 'iban' => 'IT60X0542811101000000123456',
            'sia' => 'A1234', 'cuc' => 'CUC1', 'virtual' => false,
        ], [
            'id' => 1, 'name' => 'Main account', 'type' => 'bank', 'iban' => 'IT60X0542811101000000123456',
            'sia' => 'A1234', 'cuc' => 'CUC1', 'virtual' => false,
        ]],
        'Info\PaymentMethods' => [InfoPaymentMethods::class, [
            'id' => 2, 'name' => 'Bank transfer', 'type' => 'standard', 'is_default' => true,
            'iban' => 'IT60X', 'sia' => 'S', 'cuc' => 'C', 'virtual' => true, 'title' => 'Bonifico',
            'description' => 'Pay by transfer', 'bank_iban' => 'IT60Y', 'bank_name' => 'Banca',
            'bank_beneficiary' => 'ACME', 'ei_payment_method' => 'MP05',
        ], [
            'id' => 2, 'name' => 'Bank transfer', 'type' => 'standard', 'isDefault' => true,
            'iban' => 'IT60X', 'sia' => 'S', 'cuc' => 'C', 'virtual' => true, 'title' => 'Bonifico',
            'description' => 'Pay by transfer', 'bankIban' => 'IT60Y', 'bankName' => 'Banca',
            'bankBeneficiary' => 'ACME', 'eiPaymentMethod' => 'MP05',
        ]],
        'Settings\PaymentMethods' => [SettingsPaymentMethods::class, [
            'id' => 3, 'name' => 'Cash', 'type' => 'standard', 'is_default' => false,
            'default_payment_account' => ['id' => 1], 'details' => [['title' => 'Note']],
            'bank_iban' => 'IT60Z', 'bank_name' => 'Banca', 'bank_beneficiary' => 'ACME', 'ei_payment_method' => 'MP01',
        ], [
            'id' => 3, 'name' => 'Cash', 'type' => 'standard', 'isDefault' => false,
            'bankIban' => 'IT60Z', 'bankName' => 'Banca', 'bankBeneficiary' => 'ACME', 'eiPaymentMethod' => 'MP01',
        ]],
        'Settings\SettingsCreate' => [SettingsCreate::class, [
            'iban' => 'IT60X', 'sia' => 'S', 'cuc' => 'C', 'virtual' => true,
        ], [
            'iban' => 'IT60X', 'sia' => 'S', 'cuc' => 'C', 'virtual' => true,
        ]],
        'Settings\SettingsCreateVatType' => [SettingsCreateVatType::class, [
            'value' => 22.0, 'description' => 'Standard rate', 'notes' => 'IVA ordinaria', 'e_invoice' => true,
            'ei_type' => 'N1', 'ei_description' => 'Escluse', 'is_disabled' => false,
        ], [
            'value' => 22.0, 'description' => 'Standard rate', 'notes' => 'IVA ordinaria', 'eInvoice' => true,
            'eiType' => 'N1', 'eiDescription' => 'Escluse', 'isDisabled' => false,
        ]],
        'Settings\SettingsGetVatType' => [SettingsGetVatType::class, ['editable' => true], ['editable' => true]],
        'Taxes\TaxesCreate' => [TaxesCreate::class, ['attachment_token' => 'tok_123'], ['attachmentToken' => 'tok_123']],
    ]);

    it('can be built without parameters', function (string $class) {
        expect(new $class())->toBeInstanceOf($class);
    })->with([
        ArchiveCategories::class, CostCenters::class, PaymentAccounts::class, InfoPaymentMethods::class,
        ProductsCategories::class, ReceivedDocumentCategories::class, RevenueCenters::class,
        SettingsPaymentMethods::class, SettingsCreate::class, SettingsCreateVatType::class,
        SettingsGetVatType::class, TaxesCreate::class,
    ]);
})->covers(
    ArchiveCategories::class,
    CostCenters::class,
    PaymentAccounts::class,
    InfoPaymentMethods::class,
    ProductsCategories::class,
    ReceivedDocumentCategories::class,
    RevenueCenters::class,
    SettingsPaymentMethods::class,
    SettingsCreate::class,
    SettingsCreateVatType::class,
    SettingsGetVatType::class,
    TaxesCreate::class,
);
