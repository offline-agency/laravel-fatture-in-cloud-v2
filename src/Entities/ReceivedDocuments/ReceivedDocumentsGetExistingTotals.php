<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocuments;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class ReceivedDocumentsGetExistingTotals extends AbstractEntity
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


