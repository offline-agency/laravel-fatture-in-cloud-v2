<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;
use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class PaymentAccounts extends AbstractEntity
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $name;

    public ?string $type;

    public ?string $iban;

    public ?string $sia;

    public ?string $cuc;

    public ?bool $virtual;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->name = self::nullableString($parameters, 'name');
        $this->type = self::nullableString($parameters, 'type');
        $this->iban = self::nullableString($parameters, 'iban');
        $this->sia = self::nullableString($parameters, 'sia');
        $this->cuc = self::nullableString($parameters, 'cuc');
        $this->virtual = self::nullableBool($parameters, 'virtual');
    }
}
