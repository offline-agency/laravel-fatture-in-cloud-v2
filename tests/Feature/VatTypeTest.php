<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\VatType;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\VatType as VatTypeEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\VatTypeList;

describe('VatType', function () {
    it('lists vat types', function () {
        Http::fake([
            'c/*/settings/vat_types' => Http::response([
                'data' => [
                    ['id' => 1, 'value' => 22],
                ],
            ], 200),
        ]);

        $api = new VatType();
        $response = $api->list();

        expect($response)->toBeInstanceOf(VatTypeList::class)
            ->getItems()->toHaveCount(1);
    });

    it('handles error on list vat types', function () {
        Http::fake([
            'c/*/settings/vat_types' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new VatType();
        $response = $api->list();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets vat type detail', function () {
        $vatTypeId = 1;

        Http::fake([
            'c/*/settings/vat_types/'.$vatTypeId => Http::response([
                'data' => ['id' => $vatTypeId, 'value' => 22, 'description' => 'Standard'],
            ], 200),
        ]);

        $api = new VatType();
        $response = $api->detail($vatTypeId);

        expect($response)->toBeInstanceOf(VatTypeEntity::class)
            ->and($response->id)->toBe($vatTypeId);
    });

    it('handles error on vat type detail', function () {
        Http::fake([
            'c/*/settings/vat_types/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new VatType();
        $response = $api->detail(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('deletes a vat type', function () {
        $vatTypeId = 1;

        Http::fake([
            'c/*/settings/vat_types/'.$vatTypeId => Http::response(null, 200),
        ]);

        $api = new VatType();
        $response = $api->delete($vatTypeId);

        expect($response)->toBe('VAT type deleted');
    });

    it('handles error on delete vat type', function () {
        Http::fake([
            'c/*/settings/vat_types/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new VatType();
        $response = $api->delete(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('creates a vat type', function () {
        Http::fake([
            'c/*/settings/vat_types' => Http::response([
                'data' => ['id' => 1, 'value' => 22],
            ], 200),
        ]);

        $api = new VatType();
        $response = $api->create(['data' => ['value' => 22]]);

        expect($response)->toBeInstanceOf(VatTypeEntity::class);
        expect($response->value)->toEqual(22);
    });

    it('validates on create vat type', function () {
        $api = new VatType();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.value on create vat type', function () {
        $api = new VatType();
        $response = $api->create(['data' => ['description' => 'No value']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.value');
    });

    it('handles error on create vat type', function () {
        Http::fake([
            'c/*/settings/vat_types' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new VatType();
        $response = $api->create(['data' => ['value' => 22]]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('edits a vat type', function () {
        $vatTypeId = 1;

        Http::fake([
            'c/*/settings/vat_types/'.$vatTypeId => Http::response([
                'data' => ['id' => $vatTypeId, 'value' => 10, 'description' => 'Reduced'],
            ], 200),
        ]);

        $api = new VatType();
        $response = $api->edit($vatTypeId, ['data' => ['value' => 10]]);

        expect($response)->toBeInstanceOf(VatTypeEntity::class)
            ->and($response->value)->toEqual(10);
    });

    it('validates on edit vat type', function () {
        $api = new VatType();
        $response = $api->edit(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.value on edit vat type', function () {
        $api = new VatType();
        $response = $api->edit(1, ['data' => ['description' => 'No value']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.value');
    });

    it('handles error on edit vat type', function () {
        Http::fake([
            'c/*/settings/vat_types/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new VatType();
        $response = $api->edit(1, ['data' => ['value' => 10]]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('checks if vat type list has items', function () {
        $list = new VatTypeList((object) ['data' => [
            (object) ['id' => 1, 'value' => 22],
        ]]);

        expect($list->hasItems())->toBeTrue();
    });

    it('checks if vat type list is empty', function () {
        $list = new VatTypeList((object) ['data' => []]);

        expect($list->hasItems())->toBeFalse();
    });

    it('handles null constructor parameter', function () {
        $entity = new VatTypeEntity(null);

        expect($entity->id)->toBeNull()
            ->and($entity->value)->toBeNull();
    });
});
