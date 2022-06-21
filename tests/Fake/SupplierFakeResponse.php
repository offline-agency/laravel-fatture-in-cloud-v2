<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\Document;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\DocumentList;

class SupplierFakeResponse extends FakeResponse
{
    public function getListSupplierFake(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new DocumentList())->getSupplierFake($params),
                    (new DocumentList())->getSupplierFake($params),
                ],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getSupplierFakeDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Document())->getSupplierFakeDetail($params),
        ]);
    }

    public function getSupplierFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }
}
