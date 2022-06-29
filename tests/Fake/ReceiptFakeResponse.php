<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Receipt\SingleReceipt;

class ReceiptFakeResponse extends FakeResponse
{
    public function getReceiptsFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new SingleReceipt())->getReceiptFakeDetail($params),
                    (new SingleReceipt())->getReceiptFakeDetail($params),
                ],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getEmptyReceiptFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getReceiptsFakeDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new SingleReceipt())->getReceiptFakeDetail($params),
        ]);
    }
}
