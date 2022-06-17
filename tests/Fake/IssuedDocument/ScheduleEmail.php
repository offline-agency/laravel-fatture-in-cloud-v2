<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class ScheduleEmail extends FakeResponse
{
    public function getEmailFake(
        array $params = []
    ): array
    {
        return [
            'scheduled' => $this->value($params, 'scheduled', true)
        ];
    }
}
