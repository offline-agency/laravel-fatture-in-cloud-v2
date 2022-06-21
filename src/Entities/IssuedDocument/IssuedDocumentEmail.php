<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class IssuedDocumentEmail extends AbstractEntity
{
    /**
     * @var string
     */
    public $recipient_email;

    /**
     * @var object
     */
    public $default_sender_email;

    /**
     * @var array
     */
    public $sender_emails_list;

    /**
     * @var string
     */
    public $cc_email;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $body;

    /**
     * @var bool
     */
    public $document_exists;

    /**
     * @var bool
     */
    public $delivery_note_exists;

    /**
     * @var bool
     */
    public $attachment_exists;

    /**
     * @var bool
     */
    public $accompanying_invoice_exists;

    /**
     * @var bool
     */
    public $default_attach_pdf;
}
