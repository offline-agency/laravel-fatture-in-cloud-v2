<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class PaymentMethods extends AbstractEntity
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
     * @var array
     * */
    public $default_payment_account = [
        'id' => null,
        'name' => null,
        'type' => null,
        'iban' => null,
        'sia' => null,
        'cuc' => null,
        'virtual' => null,
    ];

    /**
     * @var array
     * */
    public $details = [
        [
            'title' => null,
            'description' => null,
        ],
    ];


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
