<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Archive;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Archive\Archive as ArchiveEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Archive\ArchiveList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;

describe('Archive', function () {
    it('lists archive documents', function () {
        Http::fake([
            'c/*/archive*' => Http::response([
                'data' => [
                    ['id' => 1, 'description' => 'Doc'],
                ],
            ], 200),
        ]);

        $api = new Archive();
        $response = $api->list();

        expect($response)->toBeInstanceOf(ArchiveList::class)
            ->getItems()->toHaveCount(1);
    });

    it('handles error on list archive documents', function () {
        Http::fake([
            'c/*/archive*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Archive();
        $response = $api->list();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('returns all archive documents', function () {
        Http::fake([
            'c/*/archive*' => Http::response([
                'data' => [
                    ['id' => 1, 'description' => 'Doc 1', 'date' => '2024-01-01', 'category' => 'cat'],
                    ['id' => 2, 'description' => 'Doc 2', 'date' => '2024-01-02', 'category' => 'cat'],
                ],
                'next_page_url' => null,
            ], 200),
        ]);

        $api = new Archive();
        $response = $api->all();

        expect($response)->toBeArray()->toHaveCount(2)
            ->{0}->toBeInstanceOf(ArchiveEntity::class);
    });

    it('handles error on all archive documents', function () {
        Http::fake([
            'c/*/archive*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Archive();
        $response = $api->all();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets archive document detail', function () {
        $archiveId = 1;

        Http::fake([
            'c/*/archive/'.$archiveId => Http::response([
                'data' => ['id' => $archiveId, 'description' => 'Doc', 'date' => '2024-01-01', 'category' => 'cat'],
            ], 200),
        ]);

        $api = new Archive();
        $response = $api->detail($archiveId);

        expect($response)->toBeInstanceOf(ArchiveEntity::class)
            ->and($response->id)->toBe($archiveId);
    });

    it('handles error on archive document detail', function () {
        Http::fake([
            'c/*/archive/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Archive();
        $response = $api->detail(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('deletes an archive document', function () {
        $archiveId = 1;

        Http::fake([
            'c/*/archive/'.$archiveId => Http::response(null, 200),
        ]);

        $api = new Archive();
        $response = $api->delete($archiveId);

        expect($response)->toBe('Archive document deleted');
    });

    it('handles error on delete archive document', function () {
        Http::fake([
            'c/*/archive/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Archive();
        $response = $api->delete(999);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('creates an archive document', function () {
        Http::fake([
            'c/*/archive' => Http::response([
                'data' => ['id' => 1, 'description' => 'Doc', 'category' => 'category'],
            ], 200),
        ]);

        $api = new Archive();
        $response = $api->create(['data' => ['description' => 'Doc', 'date' => '2024-06-06', 'category' => 'category']]);

        expect($response)->toBeInstanceOf(ArchiveEntity::class);
        expect($response->description)->toEqual('Doc');
        expect($response->category)->toEqual('category');
    });

    it('validates on create archive document', function () {
        $api = new Archive();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.date on create archive document', function () {
        $api = new Archive();
        $response = $api->create(['data' => ['description' => 'Doc', 'category' => 'cat']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.date');
    });

    it('validates data.description on create archive document', function () {
        $api = new Archive();
        $response = $api->create(['data' => ['date' => '2024-01-01', 'category' => 'cat']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.description');
    });

    it('validates data.category on create archive document', function () {
        $api = new Archive();
        $response = $api->create(['data' => ['date' => '2024-01-01', 'description' => 'Doc']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.category');
    });

    it('handles error on create archive document', function () {
        Http::fake([
            'c/*/archive' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Archive();
        $response = $api->create(['data' => ['description' => 'Doc', 'date' => '2024-01-01', 'category' => 'cat']]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('edits an archive document', function () {
        $archiveId = 1;

        Http::fake([
            'c/*/archive/'.$archiveId => Http::response([
                'data' => ['id' => $archiveId, 'description' => 'Updated Doc', 'category' => 'new-cat'],
            ], 200),
        ]);

        $api = new Archive();
        $response = $api->edit($archiveId, [
            'data' => ['description' => 'Updated Doc', 'date' => '2024-01-02', 'category' => 'new-cat'],
        ]);

        expect($response)->toBeInstanceOf(ArchiveEntity::class)
            ->and($response->description)->toBe('Updated Doc');
    });

    it('validates on edit archive document', function () {
        $api = new Archive();
        $response = $api->edit(1, []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates data.date on edit archive document', function () {
        $api = new Archive();
        $response = $api->edit(1, ['data' => ['description' => 'Doc', 'category' => 'cat']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.date');
    });

    it('validates data.description on edit archive document', function () {
        $api = new Archive();
        $response = $api->edit(1, ['data' => ['date' => '2024-01-01', 'category' => 'cat']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.description');
    });

    it('validates data.category on edit archive document', function () {
        $api = new Archive();
        $response = $api->edit(1, ['data' => ['date' => '2024-01-01', 'description' => 'Doc']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.category');
    });

    it('handles error on edit archive document', function () {
        Http::fake([
            'c/*/archive/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Archive();
        $response = $api->edit(1, [
            'data' => ['description' => 'Doc', 'date' => '2024-01-01', 'category' => 'cat'],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('uploads an archive attachment', function () {
        Http::fake([
            'c/*/archive/attachment' => Http::response([
                'attachment_token' => 'tok_abc123',
            ], 200),
        ]);

        $api = new Archive();
        $response = $api->upload([
            'filename' => 'test.pdf',
            'attachment' => 'file_content',
        ]);

        expect($response)->toBeInstanceOf(stdClass::class);
    });

    it('validates filename on upload archive attachment', function () {
        $api = new Archive();
        $response = $api->upload(['attachment' => 'content']);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('filename');
    });

    it('validates attachment on upload archive attachment', function () {
        $api = new Archive();
        $response = $api->upload(['filename' => 'test.pdf']);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('attachment');
    });

    it('handles error on upload archive attachment', function () {
        Http::fake([
            'c/*/archive/attachment' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Archive();
        $response = $api->upload([
            'filename' => 'test.pdf',
            'attachment' => 'file_content',
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('navigates archive to next page', function () {
        $archiveList = new ArchiveList(json_decode(json_encode([
            'data' => [['id' => 1, 'description' => 'Doc']],
            'next_page_url' => 'https://fake_url/archive?per_page=10&page=2',
        ])));

        Http::fake(['c/*/archive*' => Http::response(['data' => [['id' => 2, 'description' => 'Doc 2']], 'next_page_url' => null], 200)]);

        expect($archiveList->getPagination()->goToNextPage())->toBeInstanceOf(ArchiveList::class);
    });

    it('returns null navigating archive to next page when no next page url', function () {
        $archiveList = new ArchiveList(json_decode(json_encode([
            'data' => [['id' => 1]],
            'next_page_url' => null,
        ])));

        expect($archiveList->getPagination()->goToNextPage())->toBeNull();
    });

    it('navigates archive to previous page', function () {
        $archiveList = new ArchiveList(json_decode(json_encode([
            'data' => [['id' => 2, 'description' => 'Doc 2']],
            'prev_page_url' => 'https://fake_url/archive?per_page=10&page=1',
        ])));

        Http::fake(['c/*/archive*' => Http::response(['data' => [['id' => 1, 'description' => 'Doc']], 'next_page_url' => null], 200)]);

        expect($archiveList->getPagination()->goToPrevPage())->toBeInstanceOf(ArchiveList::class);
    });

    it('returns null navigating archive to previous page when no prev page url', function () {
        $archiveList = new ArchiveList(json_decode(json_encode([
            'data' => [['id' => 1]],
            'prev_page_url' => null,
        ])));

        expect($archiveList->getPagination()->goToPrevPage())->toBeNull();
    });

    it('navigates archive to first page', function () {
        $archiveList = new ArchiveList(json_decode(json_encode([
            'data' => [['id' => 3, 'description' => 'Doc 3']],
            'first_page_url' => 'https://fake_url/archive?per_page=10&page=1',
        ])));

        Http::fake(['c/*/archive*' => Http::response(['data' => [['id' => 1, 'description' => 'Doc']], 'next_page_url' => null], 200)]);

        expect($archiveList->getPagination()->goToFirstPage())->toBeInstanceOf(ArchiveList::class);
    });

    it('returns null navigating archive to first page when no first page url', function () {
        $archiveList = new ArchiveList(json_decode(json_encode([
            'data' => [['id' => 1]],
            'first_page_url' => null,
        ])));

        expect($archiveList->getPagination()->goToFirstPage())->toBeNull();
    });

    it('navigates archive to last page', function () {
        $archiveList = new ArchiveList(json_decode(json_encode([
            'data' => [['id' => 1, 'description' => 'Doc']],
            'last_page_url' => 'https://fake_url/archive?per_page=10&page=5',
        ])));

        Http::fake(['c/*/archive*' => Http::response(['data' => [['id' => 5, 'description' => 'Doc 5']], 'next_page_url' => null], 200)]);

        expect($archiveList->getPagination()->goToLastPage())->toBeInstanceOf(ArchiveList::class);
    });

    it('returns null navigating archive to last page when no last page url', function () {
        $archiveList = new ArchiveList(json_decode(json_encode([
            'data' => [['id' => 1]],
            'last_page_url' => null,
        ])));

        expect($archiveList->getPagination()->goToLastPage())->toBeNull();
    });
});
