<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class ReceivedDocumentGetExistingTotals extends AbstractEntity
{
    /**
     * @var float
     */
    public $amount_due;

    /**
     * @var float
     */
    public $payments_sum;

}


