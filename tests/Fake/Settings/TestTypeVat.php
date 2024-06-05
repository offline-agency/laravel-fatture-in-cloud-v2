<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class TestTypeVat extends FakeResponse
{
    public function getFakeVatType(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 5),
            'value' => $this->value($params, 'value', 5.2),
            'description' => $this->value($params, 'description', 'A description'),
            'notes' => $this->value($params, 'notes', 'A note'),
            'e_invoice' => $this->value($params, 'e_invoice', true),
            'ei_type' => $this->value($params, 'ei_type', 'Wood'),
            'editable' => $this->value($params, 'editable', false),
            'is_disabled' => $this->value($params, 'is_disabled', false)
        ];
    }
}
