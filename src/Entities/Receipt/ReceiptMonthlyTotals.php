<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class ReceiptMonthlyTotals extends AbstractEntity
{
    /**
     * @var float
     */
    public $net;

    /**
     * @var float
     */
    public $gross;

    /**
     * @var int
     */
    public $count;
}
