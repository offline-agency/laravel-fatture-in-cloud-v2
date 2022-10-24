<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Company;

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
    public $email;

    /**
     * @var string
     */
    public $type;

    /**
     * @var bool
     */
    public $fic;

    /**
     * @var string
     */
    public $fic_plan_name;

    /**
     * @var string
     */
    public $fic_signup_date;

    /**
     * @var string
     */
    public $fic_license_expire;

    /**
     * @var bool
     */
    public $use_fic;

    /**
     * @var bool
     */
    public $fic_need_setup;

    /**
     * @var string
     */
    public $fic_license_type;

    /**
     * @var bool
     */
    public $dic;

    /**
     * @var string
     */
    public $dic_plan_name;

    /**
     * @var string
     */
    public $dic_signup_date;

    /**
     * @var string
     */
    public $dic_license_expire;

    /**
     * @var bool
     */
    public $use_dic;

    /**
     * @var string
     */
    public $dic_license_type;

    /**
     * @var string
     */
    public $registration_service;

    /**
     * @var string
     */
    public $can_use_coupon;

    /**
     * @var object
     */
    public $access_info;

    /**
     * @var object
     */
    public $plan_info;

    /**
     * @var bool
     */
    public $is_accountant;

    /**
     * @var int
     */
    public $accountant_id;

    /**
     * @var string
     */
    public $fic_payment_subject;

    /**
     * @var string
     */
    public $dic_payment_subject;
}
