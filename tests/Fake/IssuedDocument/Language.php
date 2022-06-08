<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Language extends FakeResponse
{
    public function getLanguageFake()
    {
        return (object) [
            'code' => 'it',
            'name' => 'Italiano',
        ];
    }
}
