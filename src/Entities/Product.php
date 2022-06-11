<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities;

class Product extends AbstractEntity
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
    public $code;

    /**
     * @var float
     */
    public $net_price;

    /**
     * @var float
     */
    public $gross_price;

    /**
     * @var bool
     */
    public $use_gross_price;

    /**
     * @var object
     */
    public $default_vat;//TODO: relate another class

    /**
     * @var float
     */
    public $net_cost;

    /**
     * @var string
     */
    public $measure;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $category;

    /**
     * @var string
     */
    public $notes;

    /**
     * @var bool
     */
    public $in_stock;

    /**
     * @var float
     */
    public $stock_initial;

    /**
     * @var float
     */
    public $stock_current;

    /**
     * @var float
     */
    public $average_cost;

    /**
     * @var float
     */
    public $average_price;

    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;
}
