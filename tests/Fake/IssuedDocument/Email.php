<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class Email extends FakeResponse
{
    public function getEmailFake(
        array $params = []
    ): array {
        return [
            'recipient_email' => $this->value($params, 'recipient_email', ''),
            'default_sender_email' => $this->value($params, 'default_sender_email', [
                'id' => 0,
                'email' => 'no-reply@fattureincloud.it',
            ]),
            'sender_emails_list' => $this->value($params, 'sender_emails_list', [
                [
                    'id' => 0,
                    'email' => 'no-reply@fattureincloud.it',
                ],
            ]),
            'cc_email' => $this->value($params, 'cc_email', 'fake_email@gmail.com'),
            'subject' => $this->value($params, 'subject', 'Invoice n. 1'),
            'body' => $this->value($params, 'body', ''),
            'document_exists' => $this->value($params, 'document_exists', true),
            'delivery_note_exists' => $this->value($params, 'delivery_note_exists', false),
            'attachment_exists' => $this->value($params, 'attachment_exists', false),
            'accompanying_invoice_exists' => $this->value($params, 'accompanying_invoice_exists', false),
            'default_attach_pdf' => $this->value($params, 'default_attach_pdf', false),
        ];
    }
}
