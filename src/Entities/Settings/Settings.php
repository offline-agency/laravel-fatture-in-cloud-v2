<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class Settings extends AbstractEntity
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
     * @var bool
     */
    public $is_default;

    /**
     * @var string
     */
    public $type;

    /**
     * @var array
     */
    public $details;

    /**
     * @var object
     */
    public $default_payment_account;

    /**
     * @var string
     */
    public $iban;

    /**
     * @var string
     */
    public $sia;

    /**
     * @var bool
     */
    public $virtual;

    /**
     * @var string
     */
    public $description;

    /**
     * @var int
     */
    public $value;

    /**
     * @var string
     */
    public $notes;

    /**
     * @var bool
     */
    public $e_invoice;

    /**
     * @var int
     */
    public $ei_type;

    /**
     * @var string
     */
    public $ei_description;

    /**
     * @var bool
     */
    public $editable;

    /**
     * @var bool
     */
    public $is_disabled;
}
