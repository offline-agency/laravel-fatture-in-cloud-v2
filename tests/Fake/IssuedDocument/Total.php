<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Total extends FakeResponse
{
    public function getTotalFake(
        array $params = []
    ): array {
        return [
            'amount_net' => $this->value($params, 'amount_net', 100),
            'amount_rivalsa' => $this->value($params, 'amount_rivalsa', 0),
            'amount_net_with_rivalsa' => $this->value($params, 'amount_net_with_rivalsa', 0),
            'amount_cassa' => $this->value($params, 'amount_cassa', 0),
            'taxable_amount' => $this->value($params, 'taxable_amount', 100),
            'not_taxable_amount' => $this->value($params, 'not_taxable_amount', 0),
            'amount_vat' => $this->value($params, 'amount_vat', 22),
            'amount_gross' => $this->value($params, 'amount_gross', 122),
            'taxable_amount_withholding_tax' => $this->value($params, 'taxable_amount_withholding_tax', 0),
            'amount_withholding_tax' => $this->value($params, 'amount_withholding_tax', 0),
            'taxable_amount_other_withholding_tax' => $this->value($params, 'taxable_amount_other_withholding_tax', 0),
            'amount_other_withholding_tax' => $this->value($params, 'amount_other_withholding_tax', 0),
            'amount_enasarco_taxable' => $this->value($params, 'amount_enasarco_taxable', 0),
            'stamp_duty' => $this->value($params, 'stamp_duty', 0),
            'amount_due' => $this->value($params, 'amount_due', 0),
            'amount_due_discount' => $this->value($params, 'amount_due_discount', 0),
            'amount_global_cassa_taxable' => $this->value($params, 'amount_global_cassa_taxable', 0),
            'is_enasarco_maximal_exceeded' => $this->value($params, 'is_enasarco_maximal_exceeded', false),
            'payments_sum' => $this->value($params, 'payments_sum', 122),
            'vat_list' => $this->value($params, 'vat_list', [
                '22' => [
                    'amount_net' => 100,
                    'amount_vat' => 22,
                ],
            ]),
        ];
    }
}
