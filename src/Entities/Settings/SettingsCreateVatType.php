<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class SettingsCreateVatType extends AbstractEntity
{
    use CastsFromMixed;

    public ?float $value;

    public ?string $description;

    public ?string $notes;

    public ?bool $eInvoice;

    public ?string $eiType;

    public ?string $eiDescription;

    public ?bool $isDisabled;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->value = self::nullableFloat($parameters, 'value');
        $this->description = self::nullableString($parameters, 'description');
        $this->notes = self::nullableString($parameters, 'notes');
        $this->eInvoice = self::nullableBool($parameters, 'e_invoice');
        $this->eiType = self::nullableString($parameters, 'ei_type');
        $this->eiDescription = self::nullableString($parameters, 'ei_description');
        $this->isDisabled = self::nullableBool($parameters, 'is_disabled');
    }
}
