<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class IssuedDocumentTotals extends AbstractEntity
{
    /**
     * @var float
     */
    public $amount_net;

    /**
     * @var float
     */
    public $amount_rivalsa;

    /**
     * @var float
     */
    public $amount_net_with_rivalsa;

    /**
     * @var float
     */
    public $amount_cassa;

    /**
     * @var float
     */
    public $taxable_amount;

    /**
     * @var float
     */
    public $not_taxable_amount;

    /**
     * @var float
     */
    public $amount_vat;

    /**
     * @var float
     */
    public $amount_gross;

    /**
     * @var float
     */
    public $taxable_amount_withholding_tax;

    /**
     * @var float
     */
    public $amount_withholding_tax;

    /**
     * @var float
     */
    public $taxable_amount_other_withholding_tax;

    /**
     * @var float
     */
    public $amount_other_withholding_tax;

    /**
     * @var float
     */
    public $amount_enasarco_taxable;

    /**
     * @var float
     */
    public $stamp_duty;

    /**
     * @var float
     */
    public $amount_due;

    /**
     * @var float
     */
    public $amount_due_discount;

    /**
     * @var float
     */
    public $amount_global_cassa_taxable;

    /**
     * @var bool
     */
    public $is_enasarco_maximal_exceeded;

    /**
     * @var float
     */
    public $payments_sum;

    /**
     * @var object
     */
    public $vat_list;
}
