<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class Settings extends AbstractEntity{
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
    public $type; //TODO: can be only some values

    /**
     * @var bool
     */
    public $is_default;

    /**
     * @var object
     */
    public $default_payment_account;

    /**
     * @var array
     */
    public $details;

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
