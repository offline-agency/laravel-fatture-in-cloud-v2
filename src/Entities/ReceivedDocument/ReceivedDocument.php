<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class ReceivedDocument
{
    use CastsFromMixed;

    public ?int $id;

    public ?string $type;

    public ?int $company_id;

    public mixed $merged_in;

    public mixed $entity;

    public ?string $date;

    public ?string $category;

    public ?string $description;

    public ?float $amount_net;

    public ?float $amount_vat;

    public ?float $amount_withholding_tax;

    public ?float $amount_other_withholding_tax;

    public ?float $amount_gross;

    public ?float $amortization;

    public ?string $rc_center;

    public ?string $invoice_number;

    public ?bool $is_marked;

    public ?bool $is_detailed;

    public ?bool $e_invoice;

    public ?string $next_due_date;

    public mixed $currency;

    public ?float $tax_deductibility;

    public ?float $vat_deductibility;

    /** @var array<mixed>|null */
    public ?array $item_list;

    /** @var array<mixed>|null */
    public ?array $payment_list;

    public ?string $attachment_url;

    public ?string $attachment_preview_url;

    public ?bool $auto_calculate;

    public ?string $attachment_token;

    public ?bool $locked;

    public ?string $created_at;

    public ?string $updated_at;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->type = self::nullableString($parameters, 'type');
        $this->company_id = self::nullableInt($parameters, 'company_id');
        $this->merged_in = self::mixedValue($parameters, 'merged_in');
        $this->entity = self::mixedValue($parameters, 'entity');
        $this->date = self::nullableString($parameters, 'date');
        $this->category = self::nullableString($parameters, 'category');
        $this->description = self::nullableString($parameters, 'description');
        $this->amount_net = self::nullableFloat($parameters, 'amount_net');
        $this->amount_vat = self::nullableFloat($parameters, 'amount_vat');
        $this->amount_withholding_tax = self::nullableFloat($parameters, 'amount_withholding_tax');
        $this->amount_other_withholding_tax = self::nullableFloat($parameters, 'amount_other_withholding_tax');
        $this->amount_gross = self::nullableFloat($parameters, 'amount_gross');
        $this->amortization = self::nullableFloat($parameters, 'amortization');
        $this->rc_center = self::nullableString($parameters, 'rc_center');
        $this->invoice_number = self::nullableString($parameters, 'invoice_number');
        $this->is_marked = self::nullableBool($parameters, 'is_marked');
        $this->is_detailed = self::nullableBool($parameters, 'is_detailed');
        $this->e_invoice = self::nullableBool($parameters, 'e_invoice');
        $this->next_due_date = self::nullableString($parameters, 'next_due_date');
        $this->currency = self::mixedValue($parameters, 'currency');
        $this->tax_deductibility = self::nullableFloat($parameters, 'tax_deductibility');
        $this->vat_deductibility = self::nullableFloat($parameters, 'vat_deductibility');
        $this->item_list = self::nullableArray($parameters, 'item_list');
        $this->payment_list = self::nullableArray($parameters, 'payment_list');
        $this->attachment_url = self::nullableString($parameters, 'attachment_url');
        $this->attachment_preview_url = self::nullableString($parameters, 'attachment_preview_url');
        $this->auto_calculate = self::nullableBool($parameters, 'auto_calculate');
        $this->attachment_token = self::nullableString($parameters, 'attachment_token');
        $this->locked = self::nullableBool($parameters, 'locked');
        $this->created_at = self::nullableString($parameters, 'created_at');
        $this->updated_at = self::nullableString($parameters, 'updated_at');
    }
}
