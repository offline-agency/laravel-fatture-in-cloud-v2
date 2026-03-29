<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class IssuedDocumentTotals
{
    use CastsFromMixed;

    public ?float $amountNet;

    public ?float $amountRivalsa;

    public ?float $amountNetWithRivalsa;

    public ?float $amountCassa;

    public ?float $taxableAmount;

    public ?float $notTaxableAmount;

    public ?float $amountVat;

    public ?float $amountGross;

    public ?float $taxableAmountWithholdingTax;

    public ?float $amountWithholdingTax;

    public ?float $taxableAmountOtherWithholdingTax;

    public ?float $amountOtherWithholdingTax;

    public ?float $amountEnasarcoTaxable;

    public ?float $stampDuty;

    public ?float $amountDue;

    public ?float $amountDueDiscount;

    public ?float $amountGlobalCassaTaxable;

    public ?bool $isEnasarcoMaximalExceeded;

    public ?float $paymentsSum;

    public mixed $vatList;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->amountNet = self::nullableFloat($parameters, 'amount_net');
        $this->amountRivalsa = self::nullableFloat($parameters, 'amount_rivalsa');
        $this->amountNetWithRivalsa = self::nullableFloat($parameters, 'amount_net_with_rivalsa');
        $this->amountCassa = self::nullableFloat($parameters, 'amount_cassa');
        $this->taxableAmount = self::nullableFloat($parameters, 'taxable_amount');
        $this->notTaxableAmount = self::nullableFloat($parameters, 'not_taxable_amount');
        $this->amountVat = self::nullableFloat($parameters, 'amount_vat');
        $this->amountGross = self::nullableFloat($parameters, 'amount_gross');
        $this->taxableAmountWithholdingTax = self::nullableFloat($parameters, 'taxable_amount_withholding_tax');
        $this->amountWithholdingTax = self::nullableFloat($parameters, 'amount_withholding_tax');
        $this->taxableAmountOtherWithholdingTax = self::nullableFloat($parameters, 'taxable_amount_other_withholding_tax');
        $this->amountOtherWithholdingTax = self::nullableFloat($parameters, 'amount_other_withholding_tax');
        $this->amountEnasarcoTaxable = self::nullableFloat($parameters, 'amount_enasarco_taxable');
        $this->stampDuty = self::nullableFloat($parameters, 'stamp_duty');
        $this->amountDue = self::nullableFloat($parameters, 'amount_due');
        $this->amountDueDiscount = self::nullableFloat($parameters, 'amount_due_discount');
        $this->amountGlobalCassaTaxable = self::nullableFloat($parameters, 'amount_global_cassa_taxable');
        $this->isEnasarcoMaximalExceeded = self::nullableBool($parameters, 'is_enasarco_maximal_exceeded');
        $this->paymentsSum = self::nullableFloat($parameters, 'payments_sum');
        $this->vatList = self::mixedValue($parameters, 'vat_list');
    }
}
