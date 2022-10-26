<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class MonthlyTotal extends FakeResponse
{
    public function getReceiptsFakeMonthlyTotal(
        array $params = []
    ): array {
        return [
            'net' => $this->value($params, 'net', 100),
            'gross' => $this->value($params, 'gross', 122),
            'count' => $this->value($params, 'count', 1),
        ];
    }
}
