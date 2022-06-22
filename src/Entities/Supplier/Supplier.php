<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class Supplier extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type; //TODO: can be only some values

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $contact_person;

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
    public $address_street;

    /**
     * @var string
     */
    public $address_postal_code;

    /**
     * @var string
     */
    public $address_city;

    /**
     * @var string
     */
    public $address_province;

    /**
     * @var string
     */
    public $address_extra;

    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $certified_email;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $fax;

    /**
     * @var string
     */
    public $notes;

    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;
}
