<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class CashbookEntry
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $date;

    public ?string $description;

    public ?string $kind;

    public ?string $type;

    public ?string $entityName;

    public ?object $document;

    public ?float $amountIn;

    public ?object $paymentAccountIn;

    public ?float $amountOut;

    public ?object $paymentAccountOut;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->date = self::nullableString($parameters, 'date');
        $this->description = self::nullableString($parameters, 'description');
        $this->kind = self::nullableString($parameters, 'kind');
        $this->type = self::nullableString($parameters, 'type');
        $this->entityName = self::nullableString($parameters, 'entity_name');
        $this->document = self::nullableObject($parameters, 'document');
        $this->amountIn = self::nullableFloat($parameters, 'amount_in');
        $this->paymentAccountIn = self::nullableObject($parameters, 'payment_account_in');
        $this->amountOut = self::nullableFloat($parameters, 'amount_out');
        $this->paymentAccountOut = self::nullableObject($parameters, 'payment_account_out');
    }
}
