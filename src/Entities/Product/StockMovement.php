<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Product;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class StockMovement
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $date;

    public ?float $amount;

    public ?string $description;

    public ?string $type;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->date = self::nullableString($parameters, 'date');
        $this->amount = self::nullableFloat($parameters, 'amount');
        $this->description = self::nullableString($parameters, 'description');
        $this->type = self::nullableString($parameters, 'type');
    }
}
