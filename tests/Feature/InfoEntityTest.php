<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Info;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\PaymentAccount as PaymentAccountEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat as VatEntity;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\InfoFakeResponse;

describe('Info Entity', function () {
    it('lists vat types', function () {
        Http::fake([
            '*/info/vat_types' => Http::response(
                (new InfoFakeResponse())->getVatTypesFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listVatTypes();

        expect($response)->toBeInstanceOf(InfoList::class)
            ->getItems()->toBeArray()->toHaveCount(2)
            ->getItems()->{0}->toBeInstanceOf(VatEntity::class);
    });

    it('checks if vat list has items', function () {
        Http::fake([
            '*/info/vat_types' => Http::response(
                (new InfoFakeResponse())->getVatTypesFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listVatTypes();

        expect($response->hasItems())->toBeTrue();
    });

    it('handles error on vat types list', function () {
        Http::fake([
            '*/info/vat_types' => Http::response(
                (new InfoFakeResponse())->getVatTypesFakeError(),
                401
            ),
        ]);

        $info = new Info();
        $response = $info->listVatTypes();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('lists payment accounts', function () {
        Http::fake([
            '*/info/payment_accounts' => Http::response(
                (new InfoFakeResponse())->getPaymentAccountsFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listPaymentAccounts();

        expect($response)->toBeInstanceOf(InfoList::class)
            ->getItems()->toBeArray()->toHaveCount(1)
            ->getItems()->{0}->toBeInstanceOf(PaymentAccountEntity::class);
    });

    it('handles error on payment accounts list', function () {
        Http::fake([
            '*/info/payment_accounts' => Http::response(
                (new InfoFakeResponse())->getPaymentAccountsFakeError(),
                401
            ),
        ]);

        $info = new Info();
        $response = $info->listPaymentAccounts();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('checks if vat types list is empty', function () {
        Http::fake([
            '*/info/vat_types' => Http::response(
                (new InfoFakeResponse())->getEmptyVatTypesFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listVatTypes();

        expect($response->hasItems())->toBeFalse();
    });

    it('checks if payment accounts list has items', function () {
        Http::fake([
            '*/info/payment_accounts' => Http::response(
                (new InfoFakeResponse())->getPaymentAccountsFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listPaymentAccounts();

        expect($response->hasItems())->toBeTrue();
    });

    it('checks if payment accounts list is empty', function () {
        Http::fake([
            '*/info/payment_accounts' => Http::response(
                (new InfoFakeResponse())->getEmptyPaymentAccountsFakeList()
            ),
        ]);

        $info = new Info();
        $response = $info->listPaymentAccounts();

        expect($response->hasItems())->toBeFalse();
    });

    it('handles null constructor parameter for Info PaymentAccount', function () {
        $entity = new PaymentAccountEntity(null);

        expect($entity->id)->toBeNull()
            ->and($entity->name)->toBeNull();
    });
})->covers(Info::class);
