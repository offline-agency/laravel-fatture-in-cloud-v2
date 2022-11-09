<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedEInvoice;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class IssuedEInvoiceRejectionReason extends AbstractEntity
{
    /**
     * @var string
     */
    public $reason;

    /**
     * @var string
     */
    public $ei_status;

    /**
     * @var string
     */
    public $solution;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $date;
}
