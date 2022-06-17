<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class IssuedDocumentPreCreateInfo extends AbstractEntity
{
    /**
     * @var object
     */
    public $numerations;

    /**
     * @var object
     */
    public $dn_numerations;

    /**
     * @var object
     */
    public $default_values;

    /**
     * @var object
     */
    public $extra_data_default_values;

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
    public $templates_list;

    /**
     * @var array
     */
    public $dn_templates_list;

    /**
     * @var array
     */
    public $ai_templates_list;

    /**
     * @var array
     */
    public $payment_methods_list;

    /**
     * @var array
     */
    public $payment_accounts_list;

    /**
     * @var array
     */
    public $vat_types_list;

    /**
     * @var array
     */
    public $measures_list;

    /**
     * @var array
     */
    public $languages_list;

    /**
     * @var object
     */
    public $ei_structure;
}
