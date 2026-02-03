<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;
use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class PaymentAccounts extends AbstractEntity
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

}
