<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

class ErrorFakeResponse extends FakeResponse
{
    public function getErrorFake(
        array $params = []
    ): array {
        return [
            'error' => [
                'message' => $this->value($params, 'error.message', 'fake_error'),
            ],
        ];
    }
}
