<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Archive;

readonly class Archive
{
    public ?int $id;

    public ?string $date;

    public ?string $description;

    public ?string $attachmentUrl;

    public ?string $category;

    public ?string $attachmentToken;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->id = $parameters['id'] ?? null;
        $this->date = $parameters['date'] ?? null;
        $this->description = $parameters['description'] ?? null;
        $this->attachmentUrl = $parameters['attachment_url'] ?? null;
        $this->category = $parameters['category'] ?? null;
        $this->attachmentToken = $parameters['attachment_token'] ?? null;
    }
}
