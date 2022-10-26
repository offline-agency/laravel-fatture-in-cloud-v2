<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Receipt\MonthlyTotal;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Receipt\PreCreateInfo;
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

    public function getReceiptsFakeAll(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new SingleReceipt())->getReceiptFakeDetail($params),
                    (new SingleReceipt())->getReceiptFakeDetail($params),
                ],
            ],
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

    public function getReceiptsFakePreCreateInfo(
        array $params = []
    )
    {
        return json_encode([
            'data' => (new PreCreateInfo())->getReceiptFakePreCreateInfo($params),
        ]);
    }

    public function getReceiptsFakeMonthlyTotals(
        array $params = []
    )
    {
        return json_encode(array_merge(
            [
                'data' => [
                    (new MonthlyTotal())->getReceiptsFakeMonthlyTotal($params),
                    (new MonthlyTotal())->getReceiptsFakeMonthlyTotal($params),
                ],
            ],
        ));
    }

    public function getReceiptFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }
}
