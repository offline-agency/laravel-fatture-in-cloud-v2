<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class EiTsData extends FakeResponse
{
    public function getEiTsDataFake(
        array $params = []
    ): array {
        return [
            'status' => $this->value($params, 'ei_ts_data.status', 0),
            'id' => $this->value($params, 'ei_ts_data.id', null),
            'info' => $this->value($params, 'ei_ts_data.info', null),
        ];
    }
}
