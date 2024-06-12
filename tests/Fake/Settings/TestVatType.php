<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class TestVatType extends FakeResponse
{
    public function getVatTypeFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', null),
            'value' => $this->value($params, 'value', null),
            'description' => $this->value($params, 'description', 'fake_description'),
            'notes' => $this->value($params, 'notes', 'fake_notes'),
            'e_invoice' => $this->value($params, 'e_invoice', true),
            'ei_type' => $this->value($params, 'ei_type', 'fake_ei_type'),
            'ei_description' => $this->value($params, 'ei_description', 'fake_ei_description'),
            'editable' => $this->value($params, 'editable', true),
            'is_disabled' => $this->value($params, 'is_disabled', false),
        ];
    }
}
