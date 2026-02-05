<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Receipt;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\Receipt as ReceiptEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptMonthlyTotals;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptPagination;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceiptFakeResponse;

describe('Receipt Entity', function () {
    it('lists receipts', function () {
        Http::fake([
            '*/receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeList()
            ),
        ]);

        $api = new Receipt();
        $response = $api->list();

        expect($response)->toBeInstanceOf(ReceiptList::class)
            ->getPagination()->toBeInstanceOf(ReceiptPagination::class)
            ->getItems()->toBeArray()->toHaveCount(2)
            ->getItems()->{0}->toBeInstanceOf(ReceiptEntity::class);
    });

    it('returns all receipts', function () {
        Http::fake([
            '*/receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeAll()
            ),
        ]);

        $api = new Receipt();
        $response = $api->all();

        expect($response)->toBeArray()->toHaveCount(2)
            ->{0}->toBeInstanceOf(ReceiptEntity::class);
    });

    it('gets receipt detail', function () {
        $receiptId = 1;

        Http::fake([
            '*/receipts/'.$receiptId => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeDetail()
            ),
        ]);

        $api = new Receipt();
        $response = $api->detail($receiptId);

        expect($response)->toBeInstanceOf(ReceiptEntity::class);
    });

    it('deletes a receipt', function () {
        $receiptId = 1;

        Http::fake([
            '*/receipts/'.$receiptId => Http::response(),
        ]);

        $api = new Receipt();
        $response = $api->delete($receiptId);

        expect($response)->toBe('Receipt deleted');
    });

    it('creates a receipt', function () {
        Http::fake([
            '*/receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeDetail()
            ),
        ]);

        $api = new Receipt();
        $response = $api->create([
            'data' => [
                'date' => Carbon::now()->format('Y-m-d'),
                'type' => 'sales_receipt',
                'payment_account' => [
                    'name' => 'Bank',
                ],
            ],
        ]);

        expect($response)->toBeInstanceOf(ReceiptEntity::class);
    });

    it('validates receipt creation', function () {
        $api = new Receipt();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('gets monthly totals', function () {
        $type = 'till_receipt';
        $year = 2022;

        Http::fake([
            '*/receipts/monthly_totals?type='.$type.'&year='.$year => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeMonthlyTotals()
            ),
        ]);

        $api = new Receipt();
        $response = $api->monthlyTotals($type, $year);

        expect($response)->toBeArray()->toHaveCount(2)
            ->{0}->toBeInstanceOf(ReceiptMonthlyTotals::class);
    });
});
