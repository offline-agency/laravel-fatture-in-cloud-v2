<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

readonly class PaymentAccounts extends AbstractEntity
{
    public ?int $id;

    public ?string $name;

    public ?string $type;

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

        $this->id = $parameters['id'] ?? null;
        $this->name = $parameters['name'] ?? null;
        $this->type = $parameters['type'] ?? null;
        $this->iban = $parameters['iban'] ?? null;
        $this->sia = $parameters['sia'] ?? null;
        $this->cuc = $parameters['cuc'] ?? null;
        $this->virtual = $parameters['virtual'] ?? null;
    }
}
