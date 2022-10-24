<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class Vat extends AbstractEntity
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
     * @var bool
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
     * @var bool
     */
    public $editable;

    /**
     * @var bool
     */
    public $is_disabled;
}
