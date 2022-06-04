<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class EiTsData extends FakeResponse
{
    public function getEiTsDataFake()
    {
        return (object)[
            'status' => 0,
            'id' => null,
            'info' => null,
        ];
    }
}
