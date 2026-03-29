<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Info;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

readonly class PaymentMethods extends AbstractEntity
{
    public ?int $id;

    public ?string $name;

    public ?string $type;

    public ?bool $isDefault;

    public ?string $iban;

    public ?string $sia;

    public ?string $cuc;

    public ?bool $virtual;

    public ?string $title;

    public ?string $description;

    public ?string $bankIban;

    public ?string $bankName;

    public ?string $bankBeneficiary;

    public ?string $eiPaymentMethod;

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
        $this->isDefault = $parameters['is_default'] ?? null;
        $this->iban = $parameters['iban'] ?? null;
        $this->sia = $parameters['sia'] ?? null;
        $this->cuc = $parameters['cuc'] ?? null;
        $this->virtual = $parameters['virtual'] ?? null;
        $this->title = $parameters['title'] ?? null;
        $this->description = $parameters['description'] ?? null;
        $this->bankIban = $parameters['bank_iban'] ?? null;
        $this->bankName = $parameters['bank_name'] ?? null;
        $this->bankBeneficiary = $parameters['bank_beneficiary'] ?? null;
        $this->eiPaymentMethod = $parameters['ei_payment_method'] ?? null;
    }
}
