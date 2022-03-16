<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities;

class IssuedDocument extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $numeration;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $visible_subject;

    /**
     * @var float
     */
    public $amount_net;

    /**
     * @var float
     */
    public $amount_vat;

    /**
     * @var float
     */
    public $amount_gross;

    /**
     * @var float
     */
    public $amount_due_discount;

    /**
     * @var object
     */
    public $entity;

    /**
     * @var string
     */
    public $date;

    /**
     * @var int
     */
    public $number;

    /**
     * @var string
     */
    public $next_due_date;

    /**
     * @var string
     */
    public $url;
}
