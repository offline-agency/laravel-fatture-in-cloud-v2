<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class IssuedDocument
{
    use CastsFromMixed;

    public ?int $id;

    public ?int $company_id;

    public mixed $entity;

    public ?string $type;

    public ?int $number;

    public ?string $numeration;

    public ?string $date;

    public ?int $year;

    public mixed $currency;

    public mixed $language;

    public ?string $subject;

    public ?string $visibleSubject;

    public ?string $rcCenter;

    public ?string $notes;

    public ?float $rivalsa;

    public ?float $rivalsaTaxable;

    public ?float $cassa;

    public ?float $amountCassa;

    public ?float $cassaTaxable;

    public ?float $amountCassaTaxable;

    public ?float $cassa2;

    public ?float $amountCassa2;

    public ?float $cassa2Taxable;

    public ?float $amountCassa2Taxable;

    public ?float $globalCassaTaxable;

    public ?float $amountGlobalCassaTaxable;

    public ?float $withholdingTax;

    public ?float $withholdingTaxTaxable;

    public ?float $otherWithholdingTax;

    public ?float $stampDuty;

    public mixed $paymentMethod;

    public ?bool $useSplitPayment;

    public mixed $merged_in;

    public mixed $originalDocument;

    public ?bool $useGrossPrices;

    public ?bool $eInvoice;

    public mixed $eiData;

    public ?string $eiCassaType;

    public ?string $eiCassa2Type;

    public ?string $eiWithholdingTaxCausal;

    public ?string $eiOtherWithholdingTaxType;

    public ?string $eiOtherWithholdingTaxCausal;

    public mixed $itemsList;

    public mixed $paymentsList;

    public mixed $template;

    public mixed $deliveryNoteTemplate;

    public mixed $accInvTemplate;

    public ?int $hMargins;

    public ?int $vMargins;

    public ?bool $showPayments;

    public ?bool $showPaymentMethod;

    public ?string $showTotals;

    public ?bool $showPaypalButton;

    public ?bool $showNotificationButton;

    public ?bool $showTspayButton;

    public ?bool $deliveryNote;

    public ?bool $accompanyingInvoice;

    public ?int $dnNumber;

    public ?string $dnDate;

    public ?string $dnAiPackagesNumber;

    public ?string $dnAiWeight;

    public ?string $dnAiCausal;

    public ?string $dnAiDestination;

    public ?string $dnAiTransporter;

    public ?string $dnAiNotes;

    public ?bool $isMarked;

    public ?string $createdAt;

    public ?string $updatedAt;

    public ?float $amountNet;

    public ?float $amountVat;

    public ?float $amountGross;

    public ?float $amountDueDiscount;

    public ?float $amountRivalsa;

    public ?float $amountRivalsaTaxable;

    public ?float $amountWithholdingTax;

    public ?float $amountWithholdingTaxTaxable;

    public ?float $amountOtherWithholdingTax;

    public ?float $otherWithholdingTaxTaxable;

    public ?float $amountEnasarcoTaxable;

    public mixed $extraData;

    public ?string $seenDate;

    public ?string $nextDueDate;

    public ?string $url;

    public ?string $attachmentUrl;

    public mixed $eiRaw;

    public mixed $eiTsData;

    public ?string $eiStatus;

    public ?bool $locked;

    public ?bool $hasTsPayPendingPayment;

    public ?bool $isFirstEInvoice;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->company_id = self::nullableInt($parameters, 'company_id');
        $this->entity = self::mixedValue($parameters, 'entity');
        $this->type = self::nullableString($parameters, 'type');
        $this->number = self::nullableInt($parameters, 'number');
        $this->numeration = self::nullableString($parameters, 'numeration');
        $this->date = self::nullableString($parameters, 'date');
        $this->year = self::nullableInt($parameters, 'year');
        $this->currency = self::mixedValue($parameters, 'currency');
        $this->language = self::mixedValue($parameters, 'language');
        $this->subject = self::nullableString($parameters, 'subject');
        $this->visibleSubject = self::nullableString($parameters, 'visible_subject');
        $this->rcCenter = self::nullableString($parameters, 'rc_center');
        $this->notes = self::nullableString($parameters, 'notes');
        $this->rivalsa = self::nullableFloat($parameters, 'rivalsa');
        $this->rivalsaTaxable = self::nullableFloat($parameters, 'rivalsa_taxable');
        $this->cassa = self::nullableFloat($parameters, 'cassa');
        $this->amountCassa = self::nullableFloat($parameters, 'amount_cassa');
        $this->cassaTaxable = self::nullableFloat($parameters, 'cassa_taxable');
        $this->amountCassaTaxable = self::nullableFloat($parameters, 'amount_cassa_taxable');
        $this->cassa2 = self::nullableFloat($parameters, 'cassa2');
        $this->amountCassa2 = self::nullableFloat($parameters, 'amount_cassa2');
        $this->cassa2Taxable = self::nullableFloat($parameters, 'cassa2_taxable');
        $this->amountCassa2Taxable = self::nullableFloat($parameters, 'amount_cassa2_taxable');
        $this->globalCassaTaxable = self::nullableFloat($parameters, 'global_cassa_taxable');
        $this->amountGlobalCassaTaxable = self::nullableFloat($parameters, 'amount_global_cassa_taxable');
        $this->withholdingTax = self::nullableFloat($parameters, 'withholding_tax');
        $this->withholdingTaxTaxable = self::nullableFloat($parameters, 'withholding_tax_taxable');
        $this->otherWithholdingTax = self::nullableFloat($parameters, 'other_withholding_tax');
        $this->stampDuty = self::nullableFloat($parameters, 'stamp_duty');
        $this->paymentMethod = self::mixedValue($parameters, 'payment_method');
        $this->useSplitPayment = self::nullableBool($parameters, 'use_split_payment');
        $this->merged_in = self::mixedValue($parameters, 'merged_in');
        $this->originalDocument = self::mixedValue($parameters, 'original_document');
        $this->useGrossPrices = self::nullableBool($parameters, 'use_gross_prices');
        $this->eInvoice = self::nullableBool($parameters, 'e_invoice');
        $this->eiData = self::mixedValue($parameters, 'ei_data');
        $this->eiCassaType = self::nullableString($parameters, 'ei_cassa_type');
        $this->eiCassa2Type = self::nullableString($parameters, 'ei_cassa2_type');
        $this->eiWithholdingTaxCausal = self::nullableString($parameters, 'ei_withholding_tax_causal');
        $this->eiOtherWithholdingTaxType = self::nullableString($parameters, 'ei_other_withholding_tax_type');
        $this->eiOtherWithholdingTaxCausal = self::nullableString($parameters, 'ei_other_withholding_tax_causal');
        $this->itemsList = self::mixedValue($parameters, 'items_list');
        $this->paymentsList = self::mixedValue($parameters, 'payments_list');
        $this->template = self::mixedValue($parameters, 'template');
        $this->deliveryNoteTemplate = self::mixedValue($parameters, 'delivery_note_template');
        $this->accInvTemplate = self::mixedValue($parameters, 'acc_inv_template');
        $this->hMargins = self::nullableInt($parameters, 'h_margins');
        $this->vMargins = self::nullableInt($parameters, 'v_margins');
        $this->showPayments = self::nullableBool($parameters, 'show_payments');
        $this->showPaymentMethod = self::nullableBool($parameters, 'show_payment_method');
        $this->showTotals = self::nullableString($parameters, 'show_totals');
        $this->showPaypalButton = self::nullableBool($parameters, 'show_paypal_button');
        $this->showNotificationButton = self::nullableBool($parameters, 'show_notification_button');
        $this->showTspayButton = self::nullableBool($parameters, 'show_tspay_button');
        $this->deliveryNote = self::nullableBool($parameters, 'delivery_note');
        $this->accompanyingInvoice = self::nullableBool($parameters, 'accompanying_invoice');
        $this->dnNumber = self::nullableInt($parameters, 'dn_number');
        $this->dnDate = self::nullableString($parameters, 'dn_date');
        $this->dnAiPackagesNumber = self::nullableString($parameters, 'dn_ai_packages_number');
        $this->dnAiWeight = self::nullableString($parameters, 'dn_ai_weight');
        $this->dnAiCausal = self::nullableString($parameters, 'dn_ai_causal');
        $this->dnAiDestination = self::nullableString($parameters, 'dn_ai_destination');
        $this->dnAiTransporter = self::nullableString($parameters, 'dn_ai_transporter');
        $this->dnAiNotes = self::nullableString($parameters, 'dn_ai_notes');
        $this->isMarked = self::nullableBool($parameters, 'is_marked');
        $this->createdAt = self::nullableString($parameters, 'created_at');
        $this->updatedAt = self::nullableString($parameters, 'updated_at');
        $this->amountNet = self::nullableFloat($parameters, 'amount_net');
        $this->amountVat = self::nullableFloat($parameters, 'amount_vat');
        $this->amountGross = self::nullableFloat($parameters, 'amount_gross');
        $this->amountDueDiscount = self::nullableFloat($parameters, 'amount_due_discount');
        $this->amountRivalsa = self::nullableFloat($parameters, 'amount_rivalsa');
        $this->amountRivalsaTaxable = self::nullableFloat($parameters, 'amount_rivalsa_taxable');
        $this->amountWithholdingTax = self::nullableFloat($parameters, 'amount_withholding_tax');
        $this->amountWithholdingTaxTaxable = self::nullableFloat($parameters, 'amount_withholding_tax_taxable');
        $this->amountOtherWithholdingTax = self::nullableFloat($parameters, 'amount_other_withholding_tax');
        $this->otherWithholdingTaxTaxable = self::nullableFloat($parameters, 'other_withholding_tax_taxable');
        $this->amountEnasarcoTaxable = self::nullableFloat($parameters, 'amount_enasarco_taxable');
        $this->extraData = self::mixedValue($parameters, 'extra_data');
        $this->seenDate = self::nullableString($parameters, 'seen_date');
        $this->nextDueDate = self::nullableString($parameters, 'next_due_date');
        $this->url = self::nullableString($parameters, 'url');
        $this->attachmentUrl = self::nullableString($parameters, 'attachment_url');
        $this->eiRaw = self::mixedValue($parameters, 'ei_raw');
        $this->eiTsData = self::mixedValue($parameters, 'ei_ts_data');
        $this->eiStatus = self::nullableString($parameters, 'ei_status');
        $this->locked = self::nullableBool($parameters, 'locked');
        $this->hasTsPayPendingPayment = self::nullableBool($parameters, 'has_ts_pay_pending_payment');
        $this->isFirstEInvoice = self::nullableBool($parameters, 'is_first_e_invoice');
    }
}
