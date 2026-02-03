<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

readonly class IssuedDocumentEmail
{
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
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->recipientEmail = $parameters['recipient_email'] ?? null;
        $this->defaultSenderEmail = $parameters['default_sender_email'] ?? null;
        $this->senderEmailsList = $parameters['sender_emails_list'] ?? null;
        $this->ccEmail = $parameters['cc_email'] ?? null;
        $this->subject = $parameters['subject'] ?? null;
        $this->body = $parameters['body'] ?? null;
        $this->documentExists = $parameters['document_exists'] ?? null;
        $this->deliveryNoteExists = $parameters['delivery_note_exists'] ?? null;
        $this->attachmentExists = $parameters['attachment_exists'] ?? null;
        $this->accompanyingInvoiceExists = $parameters['accompanying_invoice_exists'] ?? null;
        $this->defaultAttachPdf = $parameters['default_attach_pdf'] ?? null;
    }
}
