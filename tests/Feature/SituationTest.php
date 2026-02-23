<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Situation;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Situation\Situation as SituationEntity;

$situationData = [
    'invoice_number' => 5,
    'invoice_amount' => 1500.00,
    'quote_number' => 2,
    'quote_amount' => 300.00,
    'proforma_number' => 1,
    'proforma_amount' => 100.00,
    'receipt_number' => 3,
    'receipt_amount' => 450.00,
    'order_number' => 0,
    'order_amount' => 0,
    'credit_note_number' => 0,
    'credit_note_amount' => 0,
    'delivery_note_number' => 0,
    'delivery_note_amount' => 0,
    'work_report_number' => 0,
    'work_report_amount' => 0,
    'supplier_order_number' => 0,
    'supplier_order_amount' => 0,
    'purchase_invoice_number' => 10,
    'purchase_invoice_amount' => 2000.00,
    'purchase_credit_note_number' => 0,
    'purchase_credit_note_amount' => 0,
];

describe('Situation', function () use ($situationData) {
    it('gets the situation', function () use ($situationData) {
        Http::fake([
            'c/*/get/situation' => Http::response(['data' => $situationData], 200),
        ]);

        $api = new Situation();
        $response = $api->getSituation();

        expect($response)->toBeInstanceOf(SituationEntity::class);
    });

    it('maps situation fields correctly', function () use ($situationData) {
        Http::fake([
            'c/*/get/situation' => Http::response(['data' => $situationData], 200),
        ]);

        $api = new Situation();
        $response = $api->getSituation();

        expect($response->invoiceNumber)->toBe(5.0)
            ->and($response->invoiceAmount)->toBe(1500.0)
            ->and($response->quoteNumber)->toBe(2.0)
            ->and($response->quoteAmount)->toBe(300.0);
    });

    it('gets situation filtered by year', function () {
        Http::fake([
            'c/*/get/situation*' => Http::response([
                'data' => [
                    'invoice_number' => 3,
                    'invoice_amount' => 900.00,
                    'quote_number' => 0,
                    'quote_amount' => 0,
                    'proforma_number' => 0,
                    'proforma_amount' => 0,
                    'receipt_number' => 0,
                    'receipt_amount' => 0,
                    'order_number' => 0,
                    'order_amount' => 0,
                    'credit_note_number' => 0,
                    'credit_note_amount' => 0,
                    'delivery_note_number' => 0,
                    'delivery_note_amount' => 0,
                    'work_report_number' => 0,
                    'work_report_amount' => 0,
                    'supplier_order_number' => 0,
                    'supplier_order_amount' => 0,
                    'purchase_invoice_number' => 0,
                    'purchase_invoice_amount' => 0,
                    'purchase_credit_note_number' => 0,
                    'purchase_credit_note_amount' => 0,
                ],
            ], 200),
        ]);

        $api = new Situation();
        $response = $api->getSituation(['year' => 2024]);

        expect($response)->toBeInstanceOf(SituationEntity::class)
            ->and($response->invoiceNumber)->toBe(3.0);
    });

    it('handles error on get situation', function () {
        Http::fake([
            'c/*/get/situation' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Situation();
        $response = $api->getSituation();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('handles null constructor parameter', function () {
        $entity = new SituationEntity(null);

        expect($entity->quoteNumber)->toBe(0.0)
            ->and($entity->invoiceNumber)->toBe(0.0);
    });
});
