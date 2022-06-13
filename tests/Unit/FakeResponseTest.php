<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Unit;

use Illuminate\Support\Arr;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocumentFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\PaginationFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class FakeResponseTest extends TestCase
{
    public function test_params_on_first_level()
    {
        $per_page = 50;

        $pagination = (new PaginationFakeResponse())->getPaginationFake([
            'per_page' => $per_page
        ]);

        $this->assertEquals(50, Arr::get($pagination, 'per_page'));
    }

    public function test_params_on_second_level()
    {
        $entity_name = 'offline-agency';

        $issued_document = (new IssuedDocumentFakeResponse())->getIssuedDocumentFakeDetail([
            'entity' => [
                'name' => $entity_name
            ]
        ]);

        $issued_document = json_decode($issued_document);

        $this->assertEquals($entity_name, $issued_document->data->entity->name);
    }
}
