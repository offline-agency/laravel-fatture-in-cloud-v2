<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\Document;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument\DocumentList;

class IssuedDocumentFakeResponse extends FakeResponse
{
    public function getIssuedDocumentsFakeList(
        array $params = []
    )
    {
        return json_encode(array_merge(
            [
                'data' => [
                    (new DocumentList())->getListDocumentFake($params),
                    (new DocumentList())->getListDocumentFake($params)
                ]
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getIssuedDocumentFakeDetail(
        array $params = []
    )
    {
        return json_encode([
            'data' => (new Document())->getIssuedDocumentFakeDetail($params)
        ]);
    }

    public function getIssuedDocumentFakeError(
        array $params = []
    )
    {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }
}
