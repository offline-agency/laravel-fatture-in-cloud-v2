<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SingleRevenueCenters extends FakeResponse
{
    public function getRevenueCentersTypeFakeDetail(
        array $params = []
    ): array
    {
        return [
            'data' => $this->value($params, 'data', 'fake_data'),
        ];
    }
}
