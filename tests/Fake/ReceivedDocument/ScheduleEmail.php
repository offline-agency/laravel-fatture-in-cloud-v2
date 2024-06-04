<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class ScheduleEmail extends FakeResponse
{
    public function getEmailFake(
        array $params = []
    ): array {
        return [
            'scheduled' => $this->value($params, 'scheduled', true),
        ];
    }
}
