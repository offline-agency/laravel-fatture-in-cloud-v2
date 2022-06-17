<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Product\SingleProduct;

class ProductFakeResponse extends FakeResponse
{
    public function getProductsFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new SingleProduct())->getProductFakeDetail($params),
                    (new SingleProduct())->getProductFakeDetail($params),
                ],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getProductsFakeDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new SingleProduct())->getProductFakeDetail($params)
        ]);
    }
}
