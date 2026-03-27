<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocument;

readonly class ReceivedDocument
{
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

    public ?array $item_list;

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
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->id = $parameters['id'] ?? null;
        $this->type = $parameters['type'] ?? null;
        $this->company_id = $parameters['company_id'] ?? null;
        $this->merged_in = $parameters['merged_in'] ?? null;
        $this->entity = $parameters['entity'] ?? null;
        $this->date = $parameters['date'] ?? null;
        $this->category = $parameters['category'] ?? null;
        $this->description = $parameters['description'] ?? null;
        $this->amount_net = isset($parameters['amount_net']) ? (float) $parameters['amount_net'] : null;
        $this->amount_vat = isset($parameters['amount_vat']) ? (float) $parameters['amount_vat'] : null;
        $this->amount_withholding_tax = isset($parameters['amount_withholding_tax']) ? (float) $parameters['amount_withholding_tax'] : null;
        $this->amount_other_withholding_tax = isset($parameters['amount_other_withholding_tax']) ? (float) $parameters['amount_other_withholding_tax'] : null;
        $this->amount_gross = isset($parameters['amount_gross']) ? (float) $parameters['amount_gross'] : null;
        $this->amortization = isset($parameters['amortization']) ? (float) $parameters['amortization'] : null;
        $this->rc_center = $parameters['rc_center'] ?? null;
        $this->invoice_number = $parameters['invoice_number'] ?? null;
        $this->is_marked = $parameters['is_marked'] ?? null;
        $this->is_detailed = $parameters['is_detailed'] ?? null;
        $this->e_invoice = $parameters['e_invoice'] ?? null;
        $this->next_due_date = $parameters['next_due_date'] ?? null;
        $this->currency = $parameters['currency'] ?? null;
        $this->tax_deductibility = isset($parameters['tax_deductibility']) ? (float) $parameters['tax_deductibility'] : null;
        $this->vat_deductibility = isset($parameters['vat_deductibility']) ? (float) $parameters['vat_deductibility'] : null;
        $this->item_list = $parameters['item_list'] ?? null;
        $this->payment_list = $parameters['payment_list'] ?? null;
        $this->attachment_url = $parameters['attachment_url'] ?? null;
        $this->attachment_preview_url = $parameters['attachment_preview_url'] ?? null;
        $this->auto_calculate = $parameters['auto_calculate'] ?? null;
        $this->attachment_token = $parameters['attachment_token'] ?? null;
        $this->locked = $parameters['locked'] ?? null;
        $this->created_at = $parameters['created_at'] ?? null;
        $this->updated_at = $parameters['updated_at'] ?? null;
    }
}
