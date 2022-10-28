<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedEInvoice;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class IssuedEInvoice extends FakeResponse
{
    public function getIssuedEInvoiceFakeSend(
        array $params = []
    ): array {
        return [
            'name' => $this->value($params, 'name', 'fake_name'),
            'date' => $this->value($params, 'date', 'fake_date'),
        ];
    }

    public function getIssuedEInvoiceFakeVerifyXML(
        array $params = []
    ): array {
        return [
            'success' => $this->value($params, 'name', 'fake_success'),
        ];
    }

    public function getIssuedEInvoiceFakeGetXML(
        array $params = []
    )
    {
        return $this->value($params, 'value', 'fake_value');
    }

    public function getIssuedEInvoiceFakeRejectionReason(
        array $params = []
    ): array {
        return [
            'reason' => $this->value($params, 'name', 'fake_reason'),
            'ei_status' => $this->value($params, 'name', 'fake_ei_status'),
            'solution' => $this->value($params, 'name', 'fake_solution'),
            'code' => $this->value($params, 'name', 'fake_code'),
            'date' => $this->value($params, 'name', 'fake_date'),
        ];
    }
}
