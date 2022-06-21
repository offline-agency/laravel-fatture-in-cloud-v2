<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Client;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class Client extends AbstractEntity
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
     * @var object
     */
    public $default_vat; //TODO: relate another class

    /**
     * @var int
     */
    public $default_payment_terms;

    /**
     * @var string
     */
    public $default_payment_terms_type; //TODO: can be only some values

    /**
     * @var object
     */
    public $default_payment_method; //TODO: relate another class

    /**
     * @var string
     */
    public $bank_name;

    /**
     * @var string
     */
    public $bank_iban;

    /**
     * @var string
     */
    public $bank_swift_code;

    /**
     * @var string
     */
    public $shipping_address;

    /**
     * @var bool
     */
    public $e_invoice;

    /**
     * @var string
     */
    public $ei_code;

    /**
     * @var bool
     */
    public $discount_highlight;

    /**
     * @var float
     */
    public $default_discount;

    /**
     * @var bool
     */
    public $has_intent_declaration;

    /**
     * @var string
     */
    public $intent_declaration_protocol_number;

    /**
     * @var string
     */
    public $intent_declaration_protocol_date; //TODO: date format

    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;
}
