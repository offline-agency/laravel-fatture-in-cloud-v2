<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Cashbook;
use OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook\CashbookEntry;
use OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook\CashbookList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;

describe('Cashbook', function () {
    it('creates a cash book entry', function () {
        Http::fake([
            'c/*/cashbook' => Http::response([
                'data' => [
                    'id' => 1,
                    'date' => '2024-06-05',
                    'description' => 'A description',
                    'kind' => 'cashbook',
                    'amount_in' => 100.00,
                ],
            ], 200),
        ]);

        $cashbookApi = new Cashbook();
        $response = $cashbookApi->create([
            'data' => [
                'date' => '2024-06-05',
                'description' => 'A description',
                'kind' => 'cashbook',
                'amount_in' => 100.00,
            ],
        ]);

        expect($response)->toBeInstanceOf(CashbookEntry::class)
            ->id->toBe(1)
            ->date->toBe('2024-06-05');
    });

    it('lists cashbook entries', function () {
        Http::fake([
            'c/*/cashbook*' => Http::response([
                'data' => [
                    [
                        'id' => 1,
                        'date' => '2024-06-05',
                        'description' => 'A description',
                        'kind' => 'cashbook',
                        'amount_in' => 100.00,
                    ],
                ],
                'current_page' => 1,
                'first_page_url' => 'https://example.com/page=1',
                'from' => 1,
                'last_page' => 1,
                'last_page_url' => 'https://example.com/page=1',
                'next_page_url' => null,
                'path' => 'https://example.com',
                'per_page' => 5,
                'prev_page_url' => null,
                'to' => 1,
                'total' => 1,
            ], 200),
        ]);

        $cashbookApi = new Cashbook();
        $response = $cashbookApi->list();

        expect($response)->toBeInstanceOf(CashbookList::class)
            ->getItems()->toHaveCount(1);
    });

    it('handles error on list cashbook entries', function () {
        Http::fake([
            'c/*/cashbook*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Cashbook();
        $response = $api->list();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('returns all cashbook entries', function () {
        Http::fake([
            'c/*/cashbook*' => Http::response([
                'data' => [
                    ['id' => 1, 'date' => '2024-06-05', 'description' => 'Entry 1', 'kind' => 'cashbook'],
                    ['id' => 2, 'date' => '2024-06-06', 'description' => 'Entry 2', 'kind' => 'cashbook'],
                ],
                'next_page_url' => null,
            ], 200),
        ]);

        $api = new Cashbook();
        $response = $api->all();

        expect($response)->toBeArray()->toHaveCount(2)
            ->{0}->toBeInstanceOf(CashbookEntry::class);
    });

    it('handles error on all cashbook entries', function () {
        Http::fake([
            'c/*/cashbook*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Cashbook();
        $response = $api->all();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets cashbook entry detail', function () {
        $entryId = 1;

        Http::fake([
            'c/*/cashbook/'.$entryId => Http::response([
                'data' => ['id' => $entryId, 'date' => '2024-06-05', 'description' => 'A description', 'kind' => 'cashbook'],
            ], 200),
        ]);

        $api = new Cashbook();
        $response = $api->detail($entryId);

        expect($response)->toBeInstanceOf(CashbookEntry::class)
            ->and($response->id)->toBe($entryId);
    });

    it('handles error on cashbook entry detail', function () {
        Http::fake([
            'c/*/cashbook/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Cashbook();
        $response = $api->detail(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('deletes a cashbook entry', function () {
        $entryId = 1;

        Http::fake([
            'c/*/cashbook/'.$entryId => Http::response(null, 200),
        ]);

        $api = new Cashbook();
        $response = $api->delete($entryId);

        expect($response)->toBe('Cashbook entry deleted');
    });

    it('handles error on delete cashbook entry', function () {
        Http::fake([
            'c/*/cashbook/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Cashbook();
        $response = $api->delete(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('validates on create cashbook entry', function () {
        $api = new Cashbook();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.kind on create cashbook entry', function () {
        $api = new Cashbook();
        $response = $api->create([
            'data' => [
                'date' => '2024-06-05',
                'description' => 'A description',
                'kind' => 'invalid_kind',
            ],
        ]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.kind');
    });

    it('handles error on create cashbook entry', function () {
        Http::fake([
            'c/*/cashbook' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Cashbook();
        $response = $api->create([
            'data' => [
                'date' => '2024-06-05',
                'description' => 'A description',
                'kind' => 'cashbook',
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('edits a cashbook entry', function () {
        $entryId = 1;

        Http::fake([
            'c/*/cashbook/'.$entryId => Http::response([
                'data' => ['id' => $entryId, 'date' => '2024-06-05', 'description' => 'Updated', 'kind' => 'cashbook'],
            ], 200),
        ]);

        $api = new Cashbook();
        $response = $api->edit($entryId, [
            'data' => [
                'date' => '2024-06-05',
                'description' => 'Updated',
                'kind' => 'cashbook',
            ],
        ]);

        expect($response)->toBeInstanceOf(CashbookEntry::class)
            ->and($response->description)->toBe('Updated');
    });

    it('validates on edit cashbook entry', function () {
        $api = new Cashbook();
        $response = $api->edit(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.date on edit cashbook entry', function () {
        $api = new Cashbook();
        $response = $api->edit(1, ['data' => ['description' => 'Desc', 'kind' => 'cashbook']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.date');
    });

    it('validates data.description on edit cashbook entry', function () {
        $api = new Cashbook();
        $response = $api->edit(1, ['data' => ['date' => '2024-06-05', 'kind' => 'cashbook']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.description');
    });

    it('validates data.kind on edit cashbook entry', function () {
        $api = new Cashbook();
        $response = $api->edit(1, ['data' => ['date' => '2024-06-05', 'description' => 'Desc', 'kind' => 'invalid_kind']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.kind');
    });

    it('handles error on edit cashbook entry', function () {
        Http::fake([
            'c/*/cashbook/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Cashbook();
        $response = $api->edit(1, [
            'data' => [
                'date' => '2024-06-05',
                'description' => 'Updated',
                'kind' => 'cashbook',
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('navigates cashbook to next page', function () {
        $cashbookList = new CashbookList(json_decode(json_encode([
            'data' => [['id' => 1, 'kind' => 'cashbook']],
            'next_page_url' => 'https://fake_url/cashbook?per_page=10&page=2',
        ])));

        Http::fake(['c/*/cashbook*' => Http::response(['data' => [['id' => 2, 'kind' => 'cashbook']], 'next_page_url' => null], 200)]);

        expect($cashbookList->getPagination()->goToNextPage())->toBeInstanceOf(CashbookList::class);
    });

    it('returns null navigating cashbook to next page when no next page url', function () {
        $cashbookList = new CashbookList(json_decode(json_encode([
            'data' => [['id' => 1]],
            'next_page_url' => null,
        ])));

        expect($cashbookList->getPagination()->goToNextPage())->toBeNull();
    });

    it('navigates cashbook to previous page', function () {
        $cashbookList = new CashbookList(json_decode(json_encode([
            'data' => [['id' => 2, 'kind' => 'cashbook']],
            'prev_page_url' => 'https://fake_url/cashbook?per_page=10&page=1',
        ])));

        Http::fake(['c/*/cashbook*' => Http::response(['data' => [['id' => 1, 'kind' => 'cashbook']], 'next_page_url' => null], 200)]);

        expect($cashbookList->getPagination()->goToPrevPage())->toBeInstanceOf(CashbookList::class);
    });

    it('returns null navigating cashbook to previous page when no prev page url', function () {
        $cashbookList = new CashbookList(json_decode(json_encode([
            'data' => [['id' => 1]],
            'prev_page_url' => null,
        ])));

        expect($cashbookList->getPagination()->goToPrevPage())->toBeNull();
    });

    it('navigates cashbook to first page', function () {
        $cashbookList = new CashbookList(json_decode(json_encode([
            'data' => [['id' => 3, 'kind' => 'cashbook']],
            'first_page_url' => 'https://fake_url/cashbook?per_page=10&page=1',
        ])));

        Http::fake(['c/*/cashbook*' => Http::response(['data' => [['id' => 1, 'kind' => 'cashbook']], 'next_page_url' => null], 200)]);

        expect($cashbookList->getPagination()->goToFirstPage())->toBeInstanceOf(CashbookList::class);
    });

    it('returns null navigating cashbook to first page when no first page url', function () {
        $cashbookList = new CashbookList(json_decode(json_encode([
            'data' => [['id' => 1]],
            'first_page_url' => null,
        ])));

        expect($cashbookList->getPagination()->goToFirstPage())->toBeNull();
    });

    it('navigates cashbook to last page', function () {
        $cashbookList = new CashbookList(json_decode(json_encode([
            'data' => [['id' => 1, 'kind' => 'cashbook']],
            'last_page_url' => 'https://fake_url/cashbook?per_page=10&page=5',
        ])));

        Http::fake(['c/*/cashbook*' => Http::response(['data' => [['id' => 5, 'kind' => 'cashbook']], 'next_page_url' => null], 200)]);

        expect($cashbookList->getPagination()->goToLastPage())->toBeInstanceOf(CashbookList::class);
    });

    it('returns null navigating cashbook to last page when no last page url', function () {
        $cashbookList = new CashbookList(json_decode(json_encode([
            'data' => [['id' => 1]],
            'last_page_url' => null,
        ])));

        expect($cashbookList->getPagination()->goToLastPage())->toBeNull();
    });
});
