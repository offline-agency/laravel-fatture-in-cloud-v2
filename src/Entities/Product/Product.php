<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Product;

readonly class Product
{
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
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->id = $parameters['id'] ?? null;
        $this->name = $parameters['name'] ?? null;
        $this->code = $parameters['code'] ?? null;
        $this->netPrice = $parameters['net_price'] ?? null;
        $this->grossPrice = $parameters['gross_price'] ?? null;
        $this->useGrossPrice = $parameters['use_gross_price'] ?? null;
        $this->defaultVat = $parameters['default_vat'] ?? null;
        $this->netCost = $parameters['net_cost'] ?? null;
        $this->measure = $parameters['measure'] ?? null;
        $this->description = $parameters['description'] ?? null;
        $this->category = $parameters['category'] ?? null;
        $this->notes = $parameters['notes'] ?? null;
        $this->inStock = $parameters['in_stock'] ?? null;
        $this->stockInitial = $parameters['stock_initial'] ?? null;
        $this->stockCurrent = $parameters['stock_current'] ?? null;
        $this->averageCost = $parameters['average_cost'] ?? null;
        $this->averagePrice = $parameters['average_price'] ?? null;
        $this->createdAt = $parameters['created_at'] ?? null;
        $this->updatedAt = $parameters['updated_at'] ?? null;
    }
}
