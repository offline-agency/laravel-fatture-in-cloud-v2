<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class ReceivedDocument extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $type; //TODO: can be only some values

    /**
     * @var null|object
     */
    public $merged_in; //TODO: relate another class

    /**
     * @var object
     */
    public $entity; //TODO: relate another class

    /**
     * @var string
     */
    public $date; //TODO: date format

    /**
     * @var string
     */
    public $category;

    /**
     * @var string
     */
    public $description;

    /**
     * @var float
     */
    public $amount_net;

    /**
     * @var float
     */
    public $amount_vat;

    /**
     * @var float
     */
    public $amount_withholding_tax;

    /**
     * @var float
     */
    public $amount_other_withholding_tax;

    /**
     * @var float
     */
    public $amount_gross;

    /**
     * @var float
     */
    public $amortization;

    /**
     * @var string
     */
    public $rc_center;

    /**
     * @var string
     */
    public $invoice_number;

    /**
     * @var bool
     */
    public $is_marked;

    /**
     * @var bool
     */
    public $is_detailed;

    /**
     * @var bool
     */
    public $e_invoice;

    /**
     * @var string
     */
    public $next_due_date;

    /**
     * @var object
     */
    public $currency;

    /**
     * @var float
     */
    public $tax_deductibility;

    /**
     * @var float
     */
    public $vat_deductibility;

    /**
     * @var array
     */
    public $item_list;

    /**
     * @var array
     */
    public $payment_list;

    /**
     * @var string
     */
    public $attachment_url;

    /**
     * @var string
     */
    public $attachment_preview_url;

    /**
     * @var bool
     */
    public $auto_calculate;

    /**
     * @var string
     */
    public $attachment_token;

    /**
     * @var bool
     */
    public $locked;

    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;
}
