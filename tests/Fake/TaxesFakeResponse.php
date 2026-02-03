<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Taxes\Document;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Taxes\DocumentList;
class TaxesFakeResponse extends FakeResponse
{
    public function getTaxesFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new DocumentList())->getListDocumentFake($params),
                    (new DocumentList())->getListDocumentFake($params),
                ],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getTaxesFakeAll(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new DocumentList())->getListDocumentFake($params),
                    (new DocumentList())->getListDocumentFake($params),
                ],
            ]
        ));
    }

    public function getEmptyTaxesFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getTaxesFakeDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new Document())->getTaxesFakeDetail($params),
        ]);
    }

    public function getTaxesFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }

    public function  getTaxesFakeErrorDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new ErrorFakeResponse())->getErrorFake($params),
        ]);
    }
}
