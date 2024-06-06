<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SingleProductsCategories extends FakeResponse
{
    public function getProductsCategoriesTypeFakeDetail(
        array $params = []
    ): array
    {
        return [
            'data' => $this->value($params, 'data', 'fake_data'),
        ];
    }
}

