<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Supplier\SingleSupplier;

class SupplierFakeResponse extends FakeResponse
{
    public function getSupplierFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [
                    (new SingleSupplier())->getSupplierFakeDetail($params),
                    (new SingleSupplier())->getSupplierFakeDetail($params),
                ],
            ],
            (new PaginationFakeResponse())->getPaginationFake($params)
        ));
    }

    public function getSupplierFakeDetail(
        array $params = []
    ) {
        return json_encode([
            'data' => (new SingleSupplier())->getSupplierFakeDetail($params),
        ]);
    }

    public function getSupplierFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }
}
