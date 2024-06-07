<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Archive;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class Archive extends AbstractEntity{

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $date; //TODO: date format

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $attachment_url;

    /**
     * @var string
     */
    public $category;
}
