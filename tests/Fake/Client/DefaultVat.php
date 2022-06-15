<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Client;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class DefaultVat extends FakeResponse
{
    public function getDefaultVatDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'value' => $this->value($params, 'value', 22),
            'description' => $this->value($params, 'description', 'fake_description'),
            'notes' => $this->value($params, 'notes', 'fake_notes'),
            'e_invoice' => $this->value($params, 'e_invoice', false),
            'ei_type' => $this->value($params, 'ei_type', 'fake_ei_type'),
            'ei_description' => $this->value($params, 'ei_description', 'fake_ei_description'),
            'editable' => $this->value($params, 'editable', true),
            'is_disabled' => $this->value($params, 'is_disabled', false)
        ];
    }
}
