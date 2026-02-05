<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes;

readonly class Taxes
{
    public ?int $id;

    public ?string $type;

    public ?int $company_id;

    public ?string $dueDate;

    public ?string $status;

    public mixed $paymentAccount;

    public ?float $amount;

    public ?string $attachmentUrl;

    public ?string $description;

    public mixed $mergedIn;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->id = $parameters['id'] ?? null;
        $this->type = $parameters['type'] ?? null;
        $this->company_id = $parameters['company_id'] ?? null;
        $this->dueDate = $parameters['due_date'] ?? null;
        $this->status = $parameters['status'] ?? null;
        $this->paymentAccount = $parameters['payment_account'] ?? null;
        $this->amount = isset($parameters['amount']) ? (float) $parameters['amount'] : null;
        $this->attachmentUrl = $parameters['attachment_url'] ?? null;
        $this->description = $parameters['description'] ?? null;
        $this->mergedIn = $parameters['merged_in'] ?? null;
    }
}
