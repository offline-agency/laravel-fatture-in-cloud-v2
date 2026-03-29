<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Situation;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Situation
{
    use CastsFromMixed;

    public float $quoteNumber;

    public float $quoteAmount;

    public float $proformaNumber;

    public float $proformaAmount;

    public float $invoiceNumber;

    public float $invoiceAmount;

    public float $receiptNumber;

    public float $receiptAmount;

    public float $orderNumber;

    public float $orderAmount;

    public float $creditNoteNumber;

    public float $creditNoteAmount;

    public float $deliveryNoteNumber;

    public float $deliveryNoteAmount;

    public float $workReportNumber;

    public float $workReportAmount;

    public float $supplierOrderNumber;

    public float $supplierOrderAmount;

    public float $purchaseInvoiceNumber;

    public float $purchaseInvoiceAmount;

    public float $purchaseCreditNoteNumber;

    public float $purchaseCreditNoteAmount;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->quoteNumber = self::nullableFloat($parameters, 'quote_number') ?? 0.0;
        $this->quoteAmount = self::nullableFloat($parameters, 'quote_amount') ?? 0.0;
        $this->proformaNumber = self::nullableFloat($parameters, 'proforma_number') ?? 0.0;
        $this->proformaAmount = self::nullableFloat($parameters, 'proforma_amount') ?? 0.0;
        $this->invoiceNumber = self::nullableFloat($parameters, 'invoice_number') ?? 0.0;
        $this->invoiceAmount = self::nullableFloat($parameters, 'invoice_amount') ?? 0.0;
        $this->receiptNumber = self::nullableFloat($parameters, 'receipt_number') ?? 0.0;
        $this->receiptAmount = self::nullableFloat($parameters, 'receipt_amount') ?? 0.0;
        $this->orderNumber = self::nullableFloat($parameters, 'order_number') ?? 0.0;
        $this->orderAmount = self::nullableFloat($parameters, 'order_amount') ?? 0.0;
        $this->creditNoteNumber = self::nullableFloat($parameters, 'credit_note_number') ?? 0.0;
        $this->creditNoteAmount = self::nullableFloat($parameters, 'credit_note_amount') ?? 0.0;
        $this->deliveryNoteNumber = self::nullableFloat($parameters, 'delivery_note_number') ?? 0.0;
        $this->deliveryNoteAmount = self::nullableFloat($parameters, 'delivery_note_amount') ?? 0.0;
        $this->workReportNumber = self::nullableFloat($parameters, 'work_report_number') ?? 0.0;
        $this->workReportAmount = self::nullableFloat($parameters, 'work_report_amount') ?? 0.0;
        $this->supplierOrderNumber = self::nullableFloat($parameters, 'supplier_order_number') ?? 0.0;
        $this->supplierOrderAmount = self::nullableFloat($parameters, 'supplier_order_amount') ?? 0.0;
        $this->purchaseInvoiceNumber = self::nullableFloat($parameters, 'purchase_invoice_number') ?? 0.0;
        $this->purchaseInvoiceAmount = self::nullableFloat($parameters, 'purchase_invoice_amount') ?? 0.0;
        $this->purchaseCreditNoteNumber = self::nullableFloat($parameters, 'purchase_credit_note_number') ?? 0.0;
        $this->purchaseCreditNoteAmount = self::nullableFloat($parameters, 'purchase_credit_note_amount') ?? 0.0;
    }
}
