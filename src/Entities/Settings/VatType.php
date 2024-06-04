<?php
namespace App\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class VatType extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var float
     */
    public $value;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $notes;

    /**
     * @var boolean
     */
    public $e_invoice;

    /**
     * @var string
     */
    public $ei_type;

    /**
     * @var string
     */
    public $ei_description;

    /**
     * @var boolean
     */
    public $editable;

    /**
     * @var boolean
     */
    public $is_disabled;
}
