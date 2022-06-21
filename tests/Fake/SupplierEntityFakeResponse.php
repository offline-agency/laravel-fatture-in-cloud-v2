<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\Document;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\DocumentList;

class SupplierEntityFakeResponse extends FakeResponse
{
    public function getSupplierEntityFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new DocumentList())->getSupplierEntityFake($params),
                    (new DocumentList())->getSupplierEntityFake($params),
                ],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getSupplierEntityFakeDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Document())->getSupplierEntityFakeDetail($params),
        ]);
    }

    public function getSupplierEntityFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }
}
