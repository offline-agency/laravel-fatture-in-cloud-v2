<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Webhook;

readonly class WebhookSubscription
{
    public ?string $id;

    public ?string $sink;

    public ?bool $verified;

    public ?array $types;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->id = $parameters['id'] ?? null;
        $this->sink = $parameters['sink'] ?? null;
        $this->verified = $parameters['verified'] ?? null;
        $this->types = $parameters['types'] ?? null;
    }
}
