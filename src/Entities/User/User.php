<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\User;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class User extends AbstractEntity
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
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $hash;

    /**
     * @var string
     */
    public $picture;

    /**
     * @var bool
     */
    public $need_password_change;

    /**
     * @var bool
     */
    public $need_marketing_consents_confirmation;

    /**
     * @var bool
     */
    public $need_confirmation;

    /**
     * @var object
     */
    public $details;
}
