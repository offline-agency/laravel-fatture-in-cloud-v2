<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class MergedIn extends FakeResponse
{
    public function getMergedInFake(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'merged_in.id', 1),
            'date' => $this->value($params, 'merged_in.date', 'fake_date'),
            'number' => $this->value($params, 'merged_in.number', 1),
            'numeration' => $this->value($params, 'merged_in.numeration', ''),
            'type' => $this->value($params, 'merged_in.type', 'fake_type'),
            'link_type' => $this->value($params, 'merged_in.link_type', 'fake_link_type'),
            'description' => $this->value($params, 'merged_in.description', 'fake_description'),
        ];
    }
}
