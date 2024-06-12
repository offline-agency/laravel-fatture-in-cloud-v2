<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class CashbookEntries extends AbstractEntity
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var \DateTime
     */
    public $date;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $kind;

    /**
     * @var double
     */
    public $type;

    /**
     * @var string
     */
    public $entity_name;

    /**
     * @var array
     */
    public $document = [
        'id' => null,
        'type' => null,
        'path' => null,
    ];

    /**
     * @var float
     */
    public $amount_in;

    /**
     * @var array
     */
    public $payment_account_in = [
        'id' => null,
        'name' => null,
        'type' => 'standard',
        'iban' => null,
        'sia' => null,
        'cuc' => null,
        'virtual' => null,
    ];

    /**
     * @var float
     */
    public $amount_out;

    /**
     * @var array
     */
    public $payment_account_out = [
        'id' => null,
        'name' => null,
        'type' => 'standard',
        'iban' => null,
        'sia' => null,
        'cuc' => null,
        'virtual' => null,
    ];
}
