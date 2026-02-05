<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook;

readonly class CashbookEntry
{
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
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->id = isset($parameters['id']) ? (int) $parameters['id'] : null;
        $this->date = $parameters['date'] ?? null;
        $this->description = $parameters['description'] ?? null;
        $this->kind = $parameters['kind'] ?? null;
        $this->type = $parameters['type'] ?? null;
        $this->entityName = $parameters['entity_name'] ?? null;
        $this->document = isset($parameters['document']) ? (object) $parameters['document'] : null;
        $this->amountIn = isset($parameters['amount_in']) ? (float) $parameters['amount_in'] : null;
        $this->paymentAccountIn = isset($parameters['payment_account_in']) ? (object) $parameters['payment_account_in'] : null;
        $this->amountOut = isset($parameters['amount_out']) ? (float) $parameters['amount_out'] : null;
        $this->paymentAccountOut = isset($parameters['payment_account_out']) ? (object) $parameters['payment_account_out'] : null;
    }
}
