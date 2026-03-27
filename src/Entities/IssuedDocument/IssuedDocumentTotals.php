<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

readonly class IssuedDocumentTotals
{
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
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->amountNet = $parameters['amount_net'] ?? null;
        $this->amountRivalsa = $parameters['amount_rivalsa'] ?? null;
        $this->amountNetWithRivalsa = $parameters['amount_net_with_rivalsa'] ?? null;
        $this->amountCassa = $parameters['amount_cassa'] ?? null;
        $this->taxableAmount = $parameters['taxable_amount'] ?? null;
        $this->notTaxableAmount = $parameters['not_taxable_amount'] ?? null;
        $this->amountVat = $parameters['amount_vat'] ?? null;
        $this->amountGross = $parameters['amount_gross'] ?? null;
        $this->taxableAmountWithholdingTax = $parameters['taxable_amount_withholding_tax'] ?? null;
        $this->amountWithholdingTax = $parameters['amount_withholding_tax'] ?? null;
        $this->taxableAmountOtherWithholdingTax = $parameters['taxable_amount_other_withholding_tax'] ?? null;
        $this->amountOtherWithholdingTax = $parameters['amount_other_withholding_tax'] ?? null;
        $this->amountEnasarcoTaxable = $parameters['amount_enasarco_taxable'] ?? null;
        $this->stampDuty = $parameters['stamp_duty'] ?? null;
        $this->amountDue = $parameters['amount_due'] ?? null;
        $this->amountDueDiscount = $parameters['amount_due_discount'] ?? null;
        $this->amountGlobalCassaTaxable = $parameters['amount_global_cassa_taxable'] ?? null;
        $this->isEnasarcoMaximalExceeded = $parameters['is_enasarco_maximal_exceeded'] ?? null;
        $this->paymentsSum = $parameters['payments_sum'] ?? null;
        $this->vatList = $parameters['vat_list'] ?? null;
    }
}
