<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class ReceiptPreCreateInfo extends AbstractEntity
{
    /**
     * @var object
     */
    public $numerations;

    /**
     * @var array
     */
    public $numerations_list;

    /**
     * @var array
     */
    public $rc_centers_list;

    /**
     * @var array
     */
    public $payment_accounts_list;

    /**
     * @var array
     */
    public $categories_list;

    /**
     * @var array
     */
    public $vat_types_list;
}
