<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class SettingsCreateVatType extends AbstractEntity{

    /**
     * @var  float
     */
    public $value;

    /**
     * @var string
     */
    public $description;

    /**
     * @var  string
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
    public $is_disabled;
}
