<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Taxes
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $type;

    public ?int $company_id;

    public ?string $dueDate;

    public ?string $status;

    public mixed $paymentAccount;

    public ?float $amount;

    public ?string $attachmentUrl;

    public ?string $description;

    public mixed $merged_in;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->type = self::nullableString($parameters, 'type');
        $this->company_id = self::nullableInt($parameters, 'company_id');
        $this->dueDate = self::nullableString($parameters, 'due_date');
        $this->status = self::nullableString($parameters, 'status');
        $this->paymentAccount = self::mixedValue($parameters, 'payment_account');
        $this->amount = self::nullableFloat($parameters, 'amount');
        $this->attachmentUrl = self::nullableString($parameters, 'attachment_url');
        $this->description = self::nullableString($parameters, 'description');
        $this->merged_in = self::mixedValue($parameters, 'merged_in');
    }
}
