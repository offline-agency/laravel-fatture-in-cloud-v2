<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

readonly class IssuedDocumentScheduleEmail
{
    public ?bool $scheduled;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->scheduled = $parameters['scheduled'] ?? null;
    }
}
