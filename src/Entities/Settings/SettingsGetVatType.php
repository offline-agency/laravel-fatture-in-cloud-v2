<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

/**
 * @deprecated Not used by any API method of this package. Will be removed in 4.0.
 */
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
