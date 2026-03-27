<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt;

readonly class Receipt
{
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
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->id = $parameters['id'] ?? null;
        $this->date = $parameters['date'] ?? null;
        $this->number = $parameters['number'] ?? null;
        $this->numeration = $parameters['numeration'] ?? null;
        $this->amountNet = $parameters['amount_net'] ?? null;
        $this->amountVat = $parameters['amount_vat'] ?? null;
        $this->amountGross = $parameters['amount_gross'] ?? null;
        $this->useGrossPrices = $parameters['use_gross_prices'] ?? null;
        $this->type = $parameters['type'] ?? null;
        $this->description = $parameters['description'] ?? null;
        $this->rcCenter = $parameters['rc_center'] ?? null;
        $this->createdAt = $parameters['created_at'] ?? null;
        $this->updatedAt = $parameters['updated_at'] ?? null;
        $this->paymentAccount = $parameters['payment_account'] ?? null;
        $this->itemsList = $parameters['items_list'] ?? null;
    }
}
