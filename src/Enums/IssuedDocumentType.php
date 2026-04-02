<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Enums;

enum IssuedDocumentType: string
{
    case Invoice = 'invoice';
    case Quote = 'quote';
    case Proforma = 'proforma';
    case Receipt = 'receipt';
    case DeliveryNote = 'delivery_note';
    case CreditNote = 'credit_note';
    case Order = 'order';
    case WorkReport = 'work_report';
    case SupplierOrder = 'supplier_order';
    case SelfOwnInvoice = 'self_own_invoice';
    case SelfSupplierInvoice = 'self_supplier_invoice';
}
