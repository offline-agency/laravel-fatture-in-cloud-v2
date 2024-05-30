<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocuments;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class ReceivedDocumentsPreCreateInfo extends AbstractEntity
{
    /**
     * @var object
     */
    public $default_values;

    /**
     * @var object
     */
    public $items_default_values;

    /**
     * @var array
     */
    public $countries_list;

    /**
     * @var array
     */
    public $currencies_list;

    /**
     * @var array
     */
    public $categories_list;

    /**
     * @var array
     */
    public $payment_accounts_list;

    /**
     * @var array
     */
    public $vat_types_list;
}
