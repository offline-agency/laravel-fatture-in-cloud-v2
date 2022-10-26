<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class Receipt extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $date;

    /**
     * @var int
     */
    public $number;

    /**
     * @var string
     */
    public $numeration;

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
    public $amount_gross;

    /**
     * @var bool
     */
    public $use_gross_prices;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $rc_center;

    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;

    /**
     * @var object
     */
    public $payment_account;

    /**
     * @var array
     */
    public $items_list;
}
