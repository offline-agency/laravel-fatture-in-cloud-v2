<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class SettingsGetVatType extends AbstractEntity
{
    use CastsFromMixed;

    public ?bool $editable;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->editable = self::nullableBool($parameters, 'editable');
    }
}
