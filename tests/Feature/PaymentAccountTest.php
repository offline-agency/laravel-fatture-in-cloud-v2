<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\PaymentAccount;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentAccount as PaymentAccountEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentAccountList;

describe('PaymentAccount', function () {
    it('lists payment accounts', function () {
        Http::fake([
            'c/*/settings/payment_accounts' => Http::response([
                'data' => [
                    ['id' => 1, 'name' => 'Bank'],
                ],
            ], 200),
        ]);

        $api = new PaymentAccount();
        $response = $api->list();

        expect($response)->toBeInstanceOf(PaymentAccountList::class)
            ->getItems()->toHaveCount(1);
    });

    it('handles error on list payment accounts', function () {
        Http::fake([
            'c/*/settings/payment_accounts' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new PaymentAccount();
        $response = $api->list();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets payment account detail', function () {
        $accountId = 1;

        Http::fake([
            'c/*/settings/payment_accounts/'.$accountId => Http::response([
                'data' => ['id' => $accountId, 'name' => 'Bank', 'type' => 'bank'],
            ], 200),
        ]);

        $api = new PaymentAccount();
        $response = $api->detail($accountId);

        expect($response)->toBeInstanceOf(PaymentAccountEntity::class)
            ->and($response->id)->toBe($accountId);
    });

    it('handles error on payment account detail', function () {
        Http::fake([
            'c/*/settings/payment_accounts/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new PaymentAccount();
        $response = $api->detail(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('deletes a payment account', function () {
        $accountId = 1;

        Http::fake([
            'c/*/settings/payment_accounts/'.$accountId => Http::response(null, 200),
        ]);

        $api = new PaymentAccount();
        $response = $api->delete($accountId);

        expect($response)->toBe('Payment account deleted');
    });

    it('handles error on delete payment account', function () {
        Http::fake([
            'c/*/settings/payment_accounts/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new PaymentAccount();
        $response = $api->delete(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('creates a payment account', function () {
        Http::fake([
            'c/*/settings/payment_accounts' => Http::response([
                'data' => ['id' => 1, 'name' => 'Bank'],
            ], 200),
        ]);

        $api = new PaymentAccount();
        $response = $api->create(['data' => ['name' => 'Bank']]);

        expect($response)->toBeInstanceOf(PaymentAccountEntity::class)
            ->name->toBe('Bank');
    });

    it('validates on create payment account', function () {
        $api = new PaymentAccount();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.name on create payment account', function () {
        $api = new PaymentAccount();
        $response = $api->create(['data' => ['type' => 'bank']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.name');
    });

    it('handles error on create payment account', function () {
        Http::fake([
            'c/*/settings/payment_accounts' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new PaymentAccount();
        $response = $api->create(['data' => ['name' => 'Bank']]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('edits a payment account', function () {
        $accountId = 1;

        Http::fake([
            'c/*/settings/payment_accounts/'.$accountId => Http::response([
                'data' => ['id' => $accountId, 'name' => 'Updated Bank'],
            ], 200),
        ]);

        $api = new PaymentAccount();
        $response = $api->edit($accountId, ['data' => ['name' => 'Updated Bank']]);

        expect($response)->toBeInstanceOf(PaymentAccountEntity::class)
            ->and($response->name)->toBe('Updated Bank');
    });

    it('validates on edit payment account', function () {
        $api = new PaymentAccount();
        $response = $api->edit(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('handles error on edit payment account', function () {
        Http::fake([
            'c/*/settings/payment_accounts/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new PaymentAccount();
        $response = $api->edit(1, ['data' => ['name' => 'Bank']]);

        expect($response)->toBeInstanceOf(Error::class);
    });
});
