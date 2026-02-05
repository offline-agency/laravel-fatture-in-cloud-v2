<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\PaymentAccount;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentAccount as PaymentAccountEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentAccountList;

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

it('creates a payment account', function () {
    $data = ['data' => ['name' => 'Bank']];

    Http::fake([
        'c/*/settings/payment_accounts' => Http::response([
            'data' => ['id' => 1, 'name' => 'Bank'],
        ], 200),
    ]);

    $api = new PaymentAccount();
    $response = $api->create($data);

    expect($response)->toBeInstanceOf(PaymentAccountEntity::class)
        ->name->toBe('Bank');
});
