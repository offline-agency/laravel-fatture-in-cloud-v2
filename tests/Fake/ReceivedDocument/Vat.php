<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Vat extends FakeResponse
{
    public function getVatFake(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'vat.id', 1),
            'value' => $this->value($params, 'vat.value', 1),
            'description' => $this->value($params, 'vat.description', 'fake_description'),
            'notes' => $this->value($params, 'vat.notes', 'fake_notes'),
            'e_invoice' => $this->value($params, 'vat.e_invoice', false),
            'ei_type' => $this->value($params, 'vat.ei_type', 'fake_ei_type'),
            'ei_description' => $this->value($params, 'vat.ei_description', 'fake_ei_description'),
            'editable' => $this->value($params, 'vat.editable', false),
            'is_disabled' => $this->value($params, 'vat.is_disabled', false),
        ];
    }
}

