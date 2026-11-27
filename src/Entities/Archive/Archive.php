<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Archive;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Archive
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $date;

    public ?string $description;

    public ?string $attachmentUrl;

    public ?string $category;

    public ?string $attachmentToken;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->date = self::nullableString($parameters, 'date');
        $this->description = self::nullableString($parameters, 'description');
        $this->attachmentUrl = self::nullableString($parameters, 'attachment_url');
        $this->category = self::nullableString($parameters, 'category');
        $this->attachmentToken = self::nullableString($parameters, 'attachment_token');
    }
}
