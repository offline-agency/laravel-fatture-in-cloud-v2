<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class SettingsCreate extends AbstractEntity
{
    use CastsFromMixed;

    public ?string $iban;

    public ?string $sia;

    public ?string $cuc;

    public ?bool $virtual;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->iban = self::nullableString($parameters, 'iban');
        $this->sia = self::nullableString($parameters, 'sia');
        $this->cuc = self::nullableString($parameters, 'cuc');
        $this->virtual = self::nullableBool($parameters, 'virtual');
    }
}
