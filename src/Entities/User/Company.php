<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\User;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class Company extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $tax_code;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $access_token;

    /**
     * @var int
     */
    public $connection_id;

    /**
     * @var array
     */
    public $controlled_companies;

    /**
     * @var string
     */
    public $alias;

    /**
     * @var string
     */
    public $vat_number;

    /**
     * @var bool
     */
    public $fic;

    /**
     * @var bool
     */
    public $dic;

    /**
     * @var string
     */
    public $fic_plan;

    /**
     * @var string
     */
    public $fic_license_expire;

    /**
     * @var object
     */
    public $permissions;
}
