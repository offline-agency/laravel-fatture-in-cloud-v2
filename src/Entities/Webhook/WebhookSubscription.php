<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Webhook;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class WebhookSubscription
{
    use CastsFromMixed;

    public ?string $id;

    public ?string $sink;

    public ?bool $verified;

    /** @var array<mixed>|null */
    public ?array $types;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableString($parameters, 'id');
        $this->sink = self::nullableString($parameters, 'sink');
        $this->verified = self::nullableBool($parameters, 'verified');
        $this->types = self::nullableArray($parameters, 'types');
    }
}
