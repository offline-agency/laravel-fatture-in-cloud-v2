<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class CashBook extends AbstractEntity
{

    /**
     * @var String
     */
    public $id;

    /**
     * @var string
     */
    public $date; //TODO: date format

    /**
     * @var string
     */
    public $description;
    /**
     * @var string
     */
    public $kind;//TODO: can be only some values

    /**
     * @var string
     */
    public $type;//TODO: can be only some values

    /**
     * @var string
     */
    public $entity_name;

    /**
     * @var object
     */
    public $document;

    /**
     * @var float
     */
    public $amount_in;

    /**
     * @var object
     */
    public $payment_account_in;

    /**
     * @var float
     */
    public $amount_out;

    /**
     * @var object
     */
    public $payment_account_out;
}
