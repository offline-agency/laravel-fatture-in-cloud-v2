<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Product;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Product
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $name;

    public ?string $code;

    public ?float $netPrice;

    public ?float $grossPrice;

    public ?bool $useGrossPrice;

    public mixed $defaultVat;

    public ?float $netCost;

    public ?string $measure;

    public ?string $description;

    public ?string $category;

    public ?string $notes;

    public ?bool $inStock;

    public ?float $stockInitial;

    public ?float $stockCurrent;

    public ?float $averageCost;

    public ?float $averagePrice;

    public ?string $createdAt;

    public ?string $updatedAt;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->name = self::nullableString($parameters, 'name');
        $this->code = self::nullableString($parameters, 'code');
        $this->netPrice = self::nullableFloat($parameters, 'net_price');
        $this->grossPrice = self::nullableFloat($parameters, 'gross_price');
        $this->useGrossPrice = self::nullableBool($parameters, 'use_gross_price');
        $this->defaultVat = self::mixedValue($parameters, 'default_vat');
        $this->netCost = self::nullableFloat($parameters, 'net_cost');
        $this->measure = self::nullableString($parameters, 'measure');
        $this->description = self::nullableString($parameters, 'description');
        $this->category = self::nullableString($parameters, 'category');
        $this->notes = self::nullableString($parameters, 'notes');
        $this->inStock = self::nullableBool($parameters, 'in_stock');
        $this->stockInitial = self::nullableFloat($parameters, 'stock_initial');
        $this->stockCurrent = self::nullableFloat($parameters, 'stock_current');
        $this->averageCost = self::nullableFloat($parameters, 'average_cost');
        $this->averagePrice = self::nullableFloat($parameters, 'average_price');
        $this->createdAt = self::nullableString($parameters, 'created_at');
        $this->updatedAt = self::nullableString($parameters, 'updated_at');
    }
}
