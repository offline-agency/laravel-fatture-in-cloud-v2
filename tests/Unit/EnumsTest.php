<?php

declare(strict_types=1);

use OfflineAgency\LaravelFattureInCloudV2\Enums\IssuedDocumentType;
use OfflineAgency\LaravelFattureInCloudV2\Enums\ReceiptType;
use OfflineAgency\LaravelFattureInCloudV2\Enums\ReceivedDocumentType;

covers(
    IssuedDocumentType::class,
    ReceivedDocumentType::class,
    ReceiptType::class,
);

describe('IssuedDocumentType', function () {
    it('has 11 cases', function () {
        expect(IssuedDocumentType::cases())->toHaveCount(11);
    });

    it('resolves from valid value', function (string $value) {
        expect(IssuedDocumentType::from($value))->toBeInstanceOf(IssuedDocumentType::class);
    })->with([
        'invoice', 'quote', 'proforma', 'receipt', 'delivery_note',
        'credit_note', 'order', 'work_report', 'supplier_order',
        'self_own_invoice', 'self_supplier_invoice',
    ]);

    it('tryFrom returns null for invalid value', function () {
        expect(IssuedDocumentType::tryFrom('nonexistent'))->toBeNull();
    });

    it('has correct value for Invoice case', function () {
        expect(IssuedDocumentType::Invoice->value)->toBe('invoice');
    });
});

describe('ReceivedDocumentType', function () {
    it('has 3 cases', function () {
        expect(ReceivedDocumentType::cases())->toHaveCount(3);
    });

    it('resolves from valid value', function (string $value) {
        expect(ReceivedDocumentType::from($value))->toBeInstanceOf(ReceivedDocumentType::class);
    })->with(['expense', 'passive_credit_note', 'passive_delivery_note']);

    it('tryFrom returns null for invalid value', function () {
        expect(ReceivedDocumentType::tryFrom('nonexistent'))->toBeNull();
    });
});

describe('ReceiptType', function () {
    it('has 2 cases', function () {
        expect(ReceiptType::cases())->toHaveCount(2);
    });

    it('resolves from valid value', function (string $value) {
        expect(ReceiptType::from($value))->toBeInstanceOf(ReceiptType::class);
    })->with(['sales_receipt', 'till_receipt']);

    it('tryFrom returns null for invalid value', function () {
        expect(ReceiptType::tryFrom('nonexistent'))->toBeNull();
    });
});
