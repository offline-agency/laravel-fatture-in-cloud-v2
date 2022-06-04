<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Template extends FakeResponse
{
    public function getTemplateFake()
    {
        return (object)[
            'id' => 2821,
            'name' => 'Light Smoke',
        ];
    }
}
