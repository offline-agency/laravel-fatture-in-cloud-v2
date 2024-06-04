<?php
namespace App\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class PaymentAccount extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $company_id;

    /**
     * @var int
     */
    public $payment_account_id;



    /**
     * @var string
    */
    public $name;

    /**
     * @var string
     */
    public $type;

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
     * @var boolean
     */
    public $virtual;
}
