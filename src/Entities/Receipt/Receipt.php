<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Receipt
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $date;

    public ?int $number;

    public ?string $numeration;

    public ?float $amountNet;

    public ?float $amountVat;

    public ?float $amountGross;

    public ?bool $useGrossPrices;

    public ?string $type;

    public ?string $description;

    public ?string $rcCenter;

    public ?string $createdAt;

    public ?string $updatedAt;

    public mixed $paymentAccount;

    public mixed $itemsList;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->date = self::nullableString($parameters, 'date');
        $this->number = self::nullableInt($parameters, 'number');
        $this->numeration = self::nullableString($parameters, 'numeration');
        $this->amountNet = self::nullableFloat($parameters, 'amount_net');
        $this->amountVat = self::nullableFloat($parameters, 'amount_vat');
        $this->amountGross = self::nullableFloat($parameters, 'amount_gross');
        $this->useGrossPrices = self::nullableBool($parameters, 'use_gross_prices');
        $this->type = self::nullableString($parameters, 'type');
        $this->description = self::nullableString($parameters, 'description');
        $this->rcCenter = self::nullableString($parameters, 'rc_center');
        $this->createdAt = self::nullableString($parameters, 'created_at');
        $this->updatedAt = self::nullableString($parameters, 'updated_at');
        $this->paymentAccount = self::mixedValue($parameters, 'payment_account');
        $this->itemsList = self::mixedValue($parameters, 'items_list');
    }
}
