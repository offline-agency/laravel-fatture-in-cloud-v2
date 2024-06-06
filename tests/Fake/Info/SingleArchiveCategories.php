<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SingleArchiveCategories extends FakeResponse
{
    public function getArchiveCategoriesTypeFakeDetail(
        array $params = []
    ): array
    {
        return [
            'data' => $this->value($params, 'data', 'fake_data'),
        ];
    }
}
