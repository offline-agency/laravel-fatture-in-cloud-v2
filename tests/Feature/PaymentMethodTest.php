<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\PaymentMethod;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentMethod as PaymentMethodEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentMethodList;

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

it('creates a payment method', function () {
    $data = ['data' => ['name' => 'Credit Card']];

    Http::fake([
        'c/*/settings/payment_methods' => Http::response([
            'data' => ['id' => 1, 'name' => 'Credit Card'],
        ], 200),
    ]);

    $api = new PaymentMethod();
    $response = $api->create($data);

    expect($response)->toBeInstanceOf(PaymentMethodEntity::class)
        ->name->toBe('Credit Card');
});
