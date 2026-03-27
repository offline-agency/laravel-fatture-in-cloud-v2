<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Product;

readonly class StockMovement
{
    public ?int $id;

    public ?string $date;

    public ?float $amount;

    public ?string $description;

    public ?string $type;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->id = $parameters['id'] ?? null;
        $this->date = $parameters['date'] ?? null;
        $this->amount = isset($parameters['amount']) ? (float) $parameters['amount'] : null;
        $this->description = $parameters['description'] ?? null;
        $this->type = $parameters['type'] ?? null;
    }
}
