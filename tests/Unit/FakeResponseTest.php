<?php

use Illuminate\Support\Arr;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocumentFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\PaginationFakeResponse;

it('gets params on first level', function () {
    $pagination = (new PaginationFakeResponse())->getPaginationFake(['per_page' => 50]);

    expect(Arr::get($pagination, 'per_page'))->toBe(50);
});

it('gets params on second level', function () {
    $issued_document = (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeDetail([
        'entity' => ['name' => 'offline-agency'],
    ]);

    $data = json_decode($issued_document);

    expect($data->data->entity->name)->toBe('offline-agency');
});
