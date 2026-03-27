<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Situation;

readonly class Situation
{
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
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->quoteNumber = (float) ($parameters['quote_number'] ?? 0);
        $this->quoteAmount = (float) ($parameters['quote_amount'] ?? 0);
        $this->proformaNumber = (float) ($parameters['proforma_number'] ?? 0);
        $this->proformaAmount = (float) ($parameters['proforma_amount'] ?? 0);
        $this->invoiceNumber = (float) ($parameters['invoice_number'] ?? 0);
        $this->invoiceAmount = (float) ($parameters['invoice_amount'] ?? 0);
        $this->receiptNumber = (float) ($parameters['receipt_number'] ?? 0);
        $this->receiptAmount = (float) ($parameters['receipt_amount'] ?? 0);
        $this->orderNumber = (float) ($parameters['order_number'] ?? 0);
        $this->orderAmount = (float) ($parameters['order_amount'] ?? 0);
        $this->creditNoteNumber = (float) ($parameters['credit_note_number'] ?? 0);
        $this->creditNoteAmount = (float) ($parameters['credit_note_amount'] ?? 0);
        $this->deliveryNoteNumber = (float) ($parameters['delivery_note_number'] ?? 0);
        $this->deliveryNoteAmount = (float) ($parameters['delivery_note_amount'] ?? 0);
        $this->workReportNumber = (float) ($parameters['work_report_number'] ?? 0);
        $this->workReportAmount = (float) ($parameters['work_report_amount'] ?? 0);
        $this->supplierOrderNumber = (float) ($parameters['supplier_order_number'] ?? 0);
        $this->supplierOrderAmount = (float) ($parameters['supplier_order_amount'] ?? 0);
        $this->purchaseInvoiceNumber = (float) ($parameters['purchase_invoice_number'] ?? 0);
        $this->purchaseInvoiceAmount = (float) ($parameters['purchase_invoice_amount'] ?? 0);
        $this->purchaseCreditNoteNumber = (float) ($parameters['purchase_credit_note_number'] ?? 0);
        $this->purchaseCreditNoteAmount = (float) ($parameters['purchase_credit_note_amount'] ?? 0);
    }
}
