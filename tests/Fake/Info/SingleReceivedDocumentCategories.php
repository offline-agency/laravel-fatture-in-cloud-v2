<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SingleReceivedDocumentCategories extends FakeResponse
{
    public function getReceivedDocumentCategoriesTypeFakeDetail(
        array $params = []
    ): array
    {
        return [
            'data' => $this->value($params, 'data', 'fake_data'),
        ];
    }
}

