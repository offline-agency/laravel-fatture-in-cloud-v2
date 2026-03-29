<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

readonly class SettingsCreateVatType extends AbstractEntity
{
    public ?float $value;

    public ?string $description;

    public ?string $notes;

    public ?bool $eInvoice;

    public ?string $eiType;

    public ?string $eiDescription;

    public ?bool $isDisabled;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->value = $parameters['value'] ?? null;
        $this->description = $parameters['description'] ?? null;
        $this->notes = $parameters['notes'] ?? null;
        $this->eInvoice = $parameters['e_invoice'] ?? null;
        $this->eiType = $parameters['ei_type'] ?? null;
        $this->eiDescription = $parameters['ei_description'] ?? null;
        $this->isDisabled = $parameters['is_disabled'] ?? null;
    }
}
