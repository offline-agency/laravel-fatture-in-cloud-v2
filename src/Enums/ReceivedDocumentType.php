<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Enums;

enum ReceivedDocumentType: string
{
    case Expense = 'expense';
    case PassiveCreditNote = 'passive_credit_note';
    case PassiveDeliveryNote = 'passive_delivery_note';
}
