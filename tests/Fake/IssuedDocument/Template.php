<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Template extends FakeResponse
{
    public function getTemplateFake(
        array $params = []
    ): array
    {
        return [
            'id' => $this->value($params, 'template.id', 2821),
            'name' => $this->value($params, 'template.name', 'Light Smoke'),
        ];
    }
}
