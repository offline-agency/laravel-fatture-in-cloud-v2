<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ArchiveDocuments;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class ArchiveDocuments extends AbstractEntity
{
    /**
     * @var int|null
     */
    public $id;

    /**
     * @var date|null
     */
    public $date;

    /**
     * @var string|null
     */
    public $description;

    /**
     * @var string|null
     */
    public $attachment_url;

    /**
     * @var string
     */
    public $attachment_token;

    /**
     * @var string|null
     */
    public $category;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->id = $attributes['data']['id'] ?? null;
        $this->date = isset($attributes['data']['date']) ? new \DateTime($attributes['data']['date']) : null;
        $this->description = $attributes['data']['description'] ?? null;
        $this->attachment_url = $attributes['data']['attachment_url'] ?? null;
        $this->attachment_token = $attributes['data']['attachment_token'] ?? null;
        $this->category = $attributes['data']['category'] ?? null;
    }

}
