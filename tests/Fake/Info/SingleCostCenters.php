<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SingleCostCenters extends FakeResponse
{
    public function getCostCentersTypeFakeDetail(
        array $params = []
    ): array
    {
        return [
            'data' => $this->value($params, 'data', 'fake_data'),
        ];
    }
}
