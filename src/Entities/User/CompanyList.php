<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\User;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class CompanyList extends AbstractEntity
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
    public $alias;

    /**
     * @var string
     */
    public $vat_number;

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
    public $connection_id;

    /**
     * @var string
     */
    public $controlled_companies;

    /**
     * @var string
     */
    public $fic;

    /**
     * @var string
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
