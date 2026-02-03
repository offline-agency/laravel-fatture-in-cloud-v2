<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class SettingsCreate extends AbstractEntity{

    /**
     * @var string
     */
    public $iban;

    /**
     * @var string
     */
    public $sia;

    /**
     * @var string
     */
    public $cuc;

    /**
     * @var bool
     */
    public $virtual;
}
