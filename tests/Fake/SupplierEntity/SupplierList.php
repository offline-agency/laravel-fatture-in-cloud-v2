<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SupplierList extends FakeResponse
{
    public function getListSupplierFake(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'type' => $this->value($params, 'type', 'fake_type'),
            'numeration' => $this->value($params, 'numeration', 'fake_numeration'),
            'subject' => $this->value($params, 'subject', 'fake_subject'),
            'visible_subject' => $this->value($params, 'visible_subject', 'fake_visible_subject'),
            'amount_net' => $this->value($params, 'amount_net', 100),
            'amount_vat' => $this->value($params, 'amount_vat', 22),
            'amount_gross' => $this->value($params, 'amount_gross', 122),
            'amount_due_discount' => $this->value($params, 'amount_due_discount', 0),
            'entity' => (new Entity())->getEntityFake($params),
            'date' => $this->value($params, 'date', 'fake_date'),
            'number' => $this->value($params, 'number', 1),
            'next_due_date' => $this->value($params, 'next_due_date', null),
            'url' => $this->value($params, 'url', 'fake_url'),
        ];
    }
}
