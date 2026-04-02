<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Receipt;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\Receipt as ReceiptEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptMonthlyTotals;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptPagination;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptPreCreateInfo;
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

    it('handles error on list receipts', function () {
        Http::fake([
            'c/*/receipts' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Receipt();
        $response = $api->list();

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on all receipts', function () {
        Http::fake([
            'c/*/receipts*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Receipt();
        $response = $api->all();

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on receipt detail', function () {
        Http::fake([
            'c/*/receipts/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Receipt();
        $response = $api->detail(999);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on delete receipt', function () {
        Http::fake([
            'c/*/receipts/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Receipt();
        $response = $api->delete(999);

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on create receipt', function () {
        Http::fake([
            'c/*/receipts' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Receipt();
        $response = $api->create([
            'data' => [
                'date' => Carbon::now()->format('Y-m-d'),
                'type' => 'sales_receipt',
                'payment_account' => ['name' => 'Bank'],
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('edits a receipt', function () {
        $receiptId = 1;

        Http::fake([
            'c/*/receipts/'.$receiptId => Http::response([
                'data' => [
                    'id' => $receiptId,
                    'date' => '2024-06-05',
                    'type' => 'sales_receipt',
                    'payment_account' => ['name' => 'Bank'],
                ],
            ], 200),
        ]);

        $api = new Receipt();
        $response = $api->edit($receiptId, [
            'data' => [
                'date' => '2024-06-05',
                'type' => 'sales_receipt',
                'payment_account' => ['name' => 'Bank'],
            ],
        ]);

        expect($response)->toBeInstanceOf(ReceiptEntity::class);
    });

    it('validates on edit receipt - missing data', function () {
        $api = new Receipt();
        $response = $api->edit(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('handles error on edit receipt', function () {
        Http::fake([
            'c/*/receipts/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Receipt();
        $response = $api->edit(1, [
            'data' => [
                'date' => '2024-06-05',
                'type' => 'sales_receipt',
                'payment_account' => ['name' => 'Bank'],
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets pre-create info', function () {
        Http::fake([
            'c/*/receipts/info' => Http::response([
                'data' => [
                    'numerations_list' => [],
                    'payment_accounts_list' => [],
                    'categories_list' => [],
                    'rc_centers_list' => [],
                ],
            ], 200),
        ]);

        $api = new Receipt();
        $response = $api->preCreateInfo();

        expect($response)->toBeInstanceOf(ReceiptPreCreateInfo::class);
    });

    it('handles error on pre-create info', function () {
        Http::fake([
            'c/*/receipts/info' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Receipt();
        $response = $api->preCreateInfo();

        expect($response)->toBeInstanceOf(Error::class);
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

    it('handles error on monthly totals', function () {
        Http::fake([
            'c/*/receipts/monthly_totals*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Receipt();
        $response = $api->monthlyTotals('till_receipt', 2022);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('validates invalid type on monthly totals', function () {
        $api = new Receipt();
        $response = $api->monthlyTotals('invalid_type', 2022);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('type');
    });

    it('checks if receipt list has items', function () {
        Http::fake([
            '*/receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeList()
            ),
        ]);

        $api = new Receipt();
        $response = $api->list();

        expect($response->hasItems())->toBeTrue();
    });

    it('checks if receipt list is empty', function () {
        Http::fake([
            '*/receipts' => Http::response(
                (new ReceiptFakeResponse())->getEmptyReceiptFakeList()
            ),
        ]);

        $api = new Receipt();
        $response = $api->list();

        expect($response->hasItems())->toBeFalse();
    });

    it('navigates receipt list to next page', function () {
        $receiptList = new ReceiptList(json_decode(
            (new ReceiptFakeResponse())->getReceiptsFakeList([
                'next_page_url' => 'https://fake_url/receipts?per_page=10&page=2',
            ])
        ));

        Http::fake(['c/*/receipts*' => Http::response((new ReceiptFakeResponse())->getReceiptsFakeList())]);

        expect($receiptList->getPagination()->goToNextPage())->toBeInstanceOf(ReceiptList::class);
    });

    it('returns null navigating receipt list to next page when no next page url', function () {
        $receiptList = new ReceiptList(json_decode(
            (new ReceiptFakeResponse())->getReceiptsFakeList(['next_page_url' => null])
        ));

        expect($receiptList->getPagination()->goToNextPage())->toBeNull();
    });

    it('navigates receipt list to previous page', function () {
        $receiptList = new ReceiptList(json_decode(
            (new ReceiptFakeResponse())->getReceiptsFakeList([
                'prev_page_url' => 'https://fake_url/receipts?per_page=10&page=1',
            ])
        ));

        Http::fake(['c/*/receipts*' => Http::response((new ReceiptFakeResponse())->getReceiptsFakeList())]);

        expect($receiptList->getPagination()->goToPrevPage())->toBeInstanceOf(ReceiptList::class);
    });

    it('returns null navigating receipt list to previous page when no prev page url', function () {
        $receiptList = new ReceiptList(json_decode(
            (new ReceiptFakeResponse())->getReceiptsFakeList(['prev_page_url' => null])
        ));

        expect($receiptList->getPagination()->goToPrevPage())->toBeNull();
    });

    it('navigates receipt list to first page', function () {
        $receiptList = new ReceiptList(json_decode(
            (new ReceiptFakeResponse())->getReceiptsFakeList()
        ));

        Http::fake(['c/*/receipts*' => Http::response((new ReceiptFakeResponse())->getReceiptsFakeList())]);

        expect($receiptList->getPagination()->goToFirstPage())->toBeInstanceOf(ReceiptList::class);
    });

    it('returns null navigating receipt list to first page when no first page url', function () {
        $receiptList = new ReceiptList(json_decode(
            (new ReceiptFakeResponse())->getReceiptsFakeList(['first_page_url' => null])
        ));

        expect($receiptList->getPagination()->goToFirstPage())->toBeNull();
    });

    it('navigates receipt list to last page', function () {
        $receiptList = new ReceiptList(json_decode(
            (new ReceiptFakeResponse())->getReceiptsFakeList()
        ));

        Http::fake(['c/*/receipts*' => Http::response((new ReceiptFakeResponse())->getReceiptsFakeList())]);

        expect($receiptList->getPagination()->goToLastPage())->toBeInstanceOf(ReceiptList::class);
    });

    it('returns null navigating receipt list to last page when no last page url', function () {
        $receiptList = new ReceiptList(json_decode(
            (new ReceiptFakeResponse())->getReceiptsFakeList(['last_page_url' => null])
        ));

        expect($receiptList->getPagination()->goToLastPage())->toBeNull();
    });

    it('handles null constructor parameter', function () {
        $entity = new ReceiptEntity(null);

        expect($entity->id)->toBeNull()
            ->and($entity->date)->toBeNull();
    });
})->covers(Receipt::class);
