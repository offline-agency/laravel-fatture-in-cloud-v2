<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

readonly class SettingsCreate extends AbstractEntity
{
    public ?string $iban;

    public ?string $sia;

    public ?string $cuc;

    public ?bool $virtual;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->iban = $parameters['iban'] ?? null;
        $this->sia = $parameters['sia'] ?? null;
        $this->cuc = $parameters['cuc'] ?? null;
        $this->virtual = $parameters['virtual'] ?? null;
    }
}
