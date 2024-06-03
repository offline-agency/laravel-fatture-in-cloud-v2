<?php
namespace App\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class Setting extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     * */
    public $name;

    /**
     * @var string
     * */
    public $type;

    /**
     * @var boolean
     * */
    public $is_default;

    /**
     * @var object
     * */
    public $default_payment_account;

    /**
     * @var object
     * */
    public $details;

    /**
     * @var string
     * */
    public $bank_iban;

    /**
     * @var string;
     * */
    public $bank_name;

    /**
     * @var string
     * */
    public $bank_beneficiary;

    /**
     * @var string
     * */
    public $ei_payment_method;
}
