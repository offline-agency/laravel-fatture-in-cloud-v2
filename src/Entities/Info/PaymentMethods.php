<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;
use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class PaymentMethods extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var bool
     */
    public $is_default;

    /**
     * @var string
     */
    public $iban;

    /**
     * @var string
     */
    public $sia;

    /**
     * @var string
     */
    public $cuc;

    /**
     * @var bool
     */
    public $virtual;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $bank_iban;

    /**
     * @var string
     */
    public $bank_name;

    /**
     * @var string
     */
    public $bank_beneficiary;

    /**
     * @var string
     */
    public $ei_payment_method;
}
