<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Vat
{
    use CastsFromMixed;

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
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->company_id = self::nullableInt($parameters, 'company_id');
        $this->value = self::nullableFloat($parameters, 'value');
        $this->description = self::nullableString($parameters, 'description');
        $this->notes = self::nullableString($parameters, 'notes');
        $this->eInvoice = self::nullableBool($parameters, 'e_invoice');
        $this->eiType = self::nullableString($parameters, 'ei_type');
        $this->eiDescription = self::nullableString($parameters, 'ei_description');
        $this->editable = self::nullableBool($parameters, 'editable');
        $this->isDisabled = self::nullableBool($parameters, 'is_disabled');
    }
}
