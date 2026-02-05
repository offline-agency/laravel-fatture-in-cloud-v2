<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

readonly class PaymentMethod
{
    public ?int $id;

    public ?string $name;

    public ?string $type;

    public ?bool $isDefault;

    public ?object $defaultPaymentAccount;

    public ?array $details;

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
        $this->defaultPaymentAccount = isset($parameters['default_payment_account']) ? (object) $parameters['default_payment_account'] : null;
        $this->details = $parameters['details'] ?? null;
    }
}
