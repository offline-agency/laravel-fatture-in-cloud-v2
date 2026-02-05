<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

readonly class Vat
{
    public ?int $id;

    public ?int $company_id;

    public ?float $value;

    public ?string $description;

    public ?string $notes;

    public ?bool $eInvoice;

    public ?string $eiType;

    public ?string $eiDescription;

    public ?bool $editable;

    public ?bool $isDisabled;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->id = $parameters['id'] ?? null;
        $this->company_id = $parameters['company_id'] ?? null;
        $this->value = $parameters['value'] ?? null;
        $this->description = $parameters['description'] ?? null;
        $this->notes = $parameters['notes'] ?? null;
        $this->eInvoice = $parameters['e_invoice'] ?? null;
        $this->eiType = $parameters['ei_type'] ?? null;
        $this->eiDescription = $parameters['ei_description'] ?? null;
        $this->editable = $parameters['editable'] ?? null;
        $this->isDisabled = $parameters['is_disabled'] ?? null;
    }
}
