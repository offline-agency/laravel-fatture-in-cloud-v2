<?php

use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoArchiveCategoriesList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoCostCentersList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoPaymentAccountsList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoPaymentMethodsList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoProductsCategoriesList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoReceivedDocumentCategoriesList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoRevenueCentersList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat;

describe('Info List Entities', function () {
    it('constructs InfoArchiveCategoriesList with items', function () {
        $response = (object) ['data' => [
            (object) ['id' => 1, 'value' => 22.0, 'description' => 'VAT 22%'],
            (object) ['id' => 2, 'value' => 10.0, 'description' => 'VAT 10%'],
        ]];

        $list = new InfoArchiveCategoriesList($response);

        expect($list->getItems())->toBeArray()->toHaveCount(2)
            ->and($list->getItems()[0])->toBeInstanceOf(Vat::class)
            ->and($list->hasItems())->toBeTrue();
    });

    it('InfoArchiveCategoriesList hasItems returns false when empty', function () {
        $response = (object) ['data' => []];

        $list = new InfoArchiveCategoriesList($response);

        expect($list->hasItems())->toBeFalse();
    });

    it('constructs InfoCostCentersList with items', function () {
        $response = (object) ['data' => [
            (object) ['id' => 1, 'value' => 22.0, 'description' => 'Cost Center A'],
            (object) ['id' => 2, 'value' => 10.0, 'description' => 'Cost Center B'],
        ]];

        $list = new InfoCostCentersList($response);

        expect($list->getItems())->toBeArray()->toHaveCount(2)
            ->and($list->getItems()[0])->toBeInstanceOf(Vat::class)
            ->and($list->hasItems())->toBeTrue();
    });

    it('InfoCostCentersList hasItems returns false when empty', function () {
        $response = (object) ['data' => []];

        $list = new InfoCostCentersList($response);

        expect($list->hasItems())->toBeFalse();
    });

    it('constructs InfoPaymentAccountsList with items', function () {
        $response = (object) ['data' => [
            (object) ['id' => 1, 'value' => 0.0, 'description' => 'Bank Account'],
        ]];

        $list = new InfoPaymentAccountsList($response);

        expect($list->getItems())->toBeArray()->toHaveCount(1)
            ->and($list->getItems()[0])->toBeInstanceOf(Vat::class)
            ->and($list->hasItems())->toBeTrue();
    });

    it('InfoPaymentAccountsList hasItems returns false when empty', function () {
        $response = (object) ['data' => []];

        $list = new InfoPaymentAccountsList($response);

        expect($list->hasItems())->toBeFalse();
    });

    it('constructs InfoPaymentMethodsList with items', function () {
        $response = (object) ['data' => [
            (object) ['id' => 1, 'value' => 0.0, 'description' => 'Bank Transfer'],
        ]];

        $list = new InfoPaymentMethodsList($response);

        expect($list->getItems())->toBeArray()->toHaveCount(1)
            ->and($list->getItems()[0])->toBeInstanceOf(Vat::class)
            ->and($list->hasItems())->toBeTrue();
    });

    it('InfoPaymentMethodsList hasItems returns false when empty', function () {
        $response = (object) ['data' => []];

        $list = new InfoPaymentMethodsList($response);

        expect($list->hasItems())->toBeFalse();
    });

    it('constructs InfoProductsCategoriesList with items', function () {
        $response = (object) ['data' => [
            (object) ['id' => 1, 'value' => 0.0, 'description' => 'Electronics'],
        ]];

        $list = new InfoProductsCategoriesList($response);

        expect($list->getItems())->toBeArray()->toHaveCount(1)
            ->and($list->getItems()[0])->toBeInstanceOf(Vat::class)
            ->and($list->hasItems())->toBeTrue();
    });

    it('InfoProductsCategoriesList hasItems returns false when empty', function () {
        $response = (object) ['data' => []];

        $list = new InfoProductsCategoriesList($response);

        expect($list->hasItems())->toBeFalse();
    });

    it('constructs InfoReceivedDocumentCategoriesList with items', function () {
        $response = (object) ['data' => [
            (object) ['id' => 1, 'value' => 0.0, 'description' => 'Invoice'],
        ]];

        $list = new InfoReceivedDocumentCategoriesList($response);

        expect($list->getItems())->toBeArray()->toHaveCount(1)
            ->and($list->getItems()[0])->toBeInstanceOf(Vat::class)
            ->and($list->hasItems())->toBeTrue();
    });

    it('InfoReceivedDocumentCategoriesList hasItems returns false when empty', function () {
        $response = (object) ['data' => []];

        $list = new InfoReceivedDocumentCategoriesList($response);

        expect($list->hasItems())->toBeFalse();
    });

    it('constructs InfoRevenueCentersList with items', function () {
        $response = (object) ['data' => [
            (object) ['id' => 1, 'value' => 0.0, 'description' => 'Revenue Center A'],
        ]];

        $list = new InfoRevenueCentersList($response);

        expect($list->getItems())->toBeArray()->toHaveCount(1)
            ->and($list->getItems()[0])->toBeInstanceOf(Vat::class)
            ->and($list->hasItems())->toBeTrue();
    });

    it('InfoRevenueCentersList hasItems returns false when empty', function () {
        $response = (object) ['data' => []];

        $list = new InfoRevenueCentersList($response);

        expect($list->hasItems())->toBeFalse();
    });
})->covers(
    InfoArchiveCategoriesList::class,
    InfoCostCentersList::class,
    InfoPaymentAccountsList::class,
    InfoPaymentMethodsList::class,
    InfoProductsCategoriesList::class,
    InfoReceivedDocumentCategoriesList::class,
    InfoRevenueCentersList::class,
);
