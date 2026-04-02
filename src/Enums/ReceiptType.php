<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Enums;

enum ReceiptType: string
{
    case SalesReceipt = 'sales_receipt';
    case TillReceipt = 'till_receipt';
}
