<?php

use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;

describe('Pagination', function () {
    it('checks if it is a single page', function () {
        $pagination = new Pagination([
            'total' => 1,
            'per_page' => 10,
        ]);

        expect($pagination->isSinglePage())->toBeTrue();

        $pagination = new Pagination([
            'total' => 15,
            'per_page' => 10,
        ]);

        expect($pagination->isSinglePage())->toBeFalse();
    });

    it('checks if it has a next page', function () {
        $pagination = new Pagination([
            'next_page_url' => 'https://fake_url/entity?per_page=10&page=2',
        ]);

        expect($pagination->hasNextPage())->toBeTrue();

        $pagination = new Pagination([
            'next_page_url' => null,
        ]);

        expect($pagination->hasNextPage())->toBeFalse();
    });

    it('checks if it has a previous page', function () {
        $pagination = new Pagination([
            'prev_page_url' => 'https://fake_url/entity?per_page=10&page=2',
        ]);

        expect($pagination->hasPrevPage())->toBeTrue();

        $pagination = new Pagination([
            'prev_page_url' => null,
        ]);

        expect($pagination->hasPrevPage())->toBeFalse();
    });

    it('extracts query parameters from url', function () {
        $pagination = new Pagination();

        $queryParams = $pagination->getQueryParams('https://fake_url.com/entity?first=Lorem&second=Ipsum');

        expect($queryParams)->toBeArray()
            ->toHaveKey('first', 'Lorem')
            ->toHaveKey('second', 'Ipsum');
    });

    it('returns empty array for url without query string', function () {
        $pagination = new Pagination();

        $queryParams = $pagination->getQueryParams('https://fake_url.com/entity');

        expect($queryParams)->toBeArray()->toBeEmpty();
    });
})->covers(Pagination::class);
