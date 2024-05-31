<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Values extends FakeResponse
{
    public function getValuesFake(
        array $params = []
    ): array
    {
        return [
            'detailed' => $this->value($params, 'values.detailed', false),
        ];
    }
}
