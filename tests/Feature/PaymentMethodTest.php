<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\PaymentMethod;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentMethod as PaymentMethodEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentMethodList;

describe('PaymentMethod', function () {
    it('lists payment methods', function () {
        Http::fake([
            'c/*/settings/payment_methods' => Http::response([
                'data' => [
                    ['id' => 1, 'name' => 'Credit Card'],
                ],
            ], 200),
        ]);

        $api = new PaymentMethod();
        $response = $api->list();

        expect($response)->toBeInstanceOf(PaymentMethodList::class)
            ->getItems()->toHaveCount(1);
    });

    it('handles error on list payment methods', function () {
        Http::fake([
            'c/*/settings/payment_methods' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new PaymentMethod();
        $response = $api->list();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets payment method detail', function () {
        $methodId = 1;

        Http::fake([
            'c/*/settings/payment_methods/'.$methodId => Http::response([
                'data' => ['id' => $methodId, 'name' => 'Credit Card', 'type' => 'standard'],
            ], 200),
        ]);

        $api = new PaymentMethod();
        $response = $api->detail($methodId);

        expect($response)->toBeInstanceOf(PaymentMethodEntity::class)
            ->and($response->id)->toBe($methodId);
    });

    it('handles error on payment method detail', function () {
        Http::fake([
            'c/*/settings/payment_methods/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new PaymentMethod();
        $response = $api->detail(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('deletes a payment method', function () {
        $methodId = 1;

        Http::fake([
            'c/*/settings/payment_methods/'.$methodId => Http::response(null, 200),
        ]);

        $api = new PaymentMethod();
        $response = $api->delete($methodId);

        expect($response)->toBe('Payment method deleted');
    });

    it('handles error on delete payment method', function () {
        Http::fake([
            'c/*/settings/payment_methods/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new PaymentMethod();
        $response = $api->delete(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('creates a payment method', function () {
        Http::fake([
            'c/*/settings/payment_methods' => Http::response([
                'data' => ['id' => 1, 'name' => 'Credit Card'],
            ], 200),
        ]);

        $api = new PaymentMethod();
        $response = $api->create(['data' => ['name' => 'Credit Card']]);

        expect($response)->toBeInstanceOf(PaymentMethodEntity::class)
            ->name->toBe('Credit Card');
    });

    it('validates on create payment method', function () {
        $api = new PaymentMethod();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.name on create payment method', function () {
        $api = new PaymentMethod();
        $response = $api->create(['data' => ['type' => 'standard']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.name');
    });

    it('handles error on create payment method', function () {
        Http::fake([
            'c/*/settings/payment_methods' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new PaymentMethod();
        $response = $api->create(['data' => ['name' => 'Credit Card']]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('edits a payment method', function () {
        $methodId = 1;

        Http::fake([
            'c/*/settings/payment_methods/'.$methodId => Http::response([
                'data' => ['id' => $methodId, 'name' => 'Updated Card'],
            ], 200),
        ]);

        $api = new PaymentMethod();
        $response = $api->edit($methodId, ['data' => ['name' => 'Updated Card']]);

        expect($response)->toBeInstanceOf(PaymentMethodEntity::class)
            ->and($response->name)->toBe('Updated Card');
    });

    it('validates on edit payment method', function () {
        $api = new PaymentMethod();
        $response = $api->edit(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.name on edit payment method', function () {
        $api = new PaymentMethod();
        $response = $api->edit(1, ['data' => ['type' => 'standard']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.name');
    });

    it('handles error on edit payment method', function () {
        Http::fake([
            'c/*/settings/payment_methods/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new PaymentMethod();
        $response = $api->edit(1, ['data' => ['name' => 'Credit Card']]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('checks if payment method list has items', function () {
        $list = new PaymentMethodList((object) ['data' => [
            (object) ['id' => 1, 'name' => 'Credit Card'],
        ]]);

        expect($list->hasItems())->toBeTrue();
    });

    it('checks if payment method list is empty', function () {
        $list = new PaymentMethodList((object) ['data' => []]);

        expect($list->hasItems())->toBeFalse();
    });
});
