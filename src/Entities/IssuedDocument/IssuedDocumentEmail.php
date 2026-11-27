<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class IssuedDocumentEmail
{
    use CastsFromMixed;

    public ?string $recipientEmail;

    public mixed $defaultSenderEmail;

    public mixed $senderEmailsList;

    public ?string $ccEmail;

    public ?string $subject;

    public ?string $body;

    public ?bool $documentExists;

    public ?bool $deliveryNoteExists;

    public ?bool $attachmentExists;

    public ?bool $accompanyingInvoiceExists;

    public ?bool $defaultAttachPdf;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->recipientEmail = self::nullableString($parameters, 'recipient_email');
        $this->defaultSenderEmail = self::mixedValue($parameters, 'default_sender_email');
        $this->senderEmailsList = self::mixedValue($parameters, 'sender_emails_list');
        $this->ccEmail = self::nullableString($parameters, 'cc_email');
        $this->subject = self::nullableString($parameters, 'subject');
        $this->body = self::nullableString($parameters, 'body');
        $this->documentExists = self::nullableBool($parameters, 'document_exists');
        $this->deliveryNoteExists = self::nullableBool($parameters, 'delivery_note_exists');
        $this->attachmentExists = self::nullableBool($parameters, 'attachment_exists');
        $this->accompanyingInvoiceExists = self::nullableBool($parameters, 'accompanying_invoice_exists');
        $this->defaultAttachPdf = self::nullableBool($parameters, 'default_attach_pdf');
    }
}
