<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class Taxes extends AbstractEntity
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
     * @var string
     */
    public $due_date; //TODO: date format

    /**
     * @var string
     */
    public $status; //TODO: can be only some values

    /**
     * @var object
     */
    public $payment_account;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $attachment_url;

    /**
     * @var string
     */
    public $description;
}

