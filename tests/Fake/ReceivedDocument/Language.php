<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Language extends FakeResponse
{
    public function getLanguageFake(
        array $params = []
    ): array {
        return [
            'code' => $this->value($params, 'language.code', 'it'),
            'name' => $this->value($params, 'language.name','Italiano')
        ];
    }
}
