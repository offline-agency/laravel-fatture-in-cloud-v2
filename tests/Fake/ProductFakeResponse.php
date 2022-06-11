<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

class ProductFakeResponse extends FakeResponse
{
    public function getIssuedDocumentsFakeList()
    {
        return json_encode((object) [
            //
        ]);
    }
}
