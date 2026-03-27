<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Email;

readonly class Email
{
    public ?int $id;

    public ?string $status;

    public ?string $sentDate;

    public ?string $errorsCount;

    public ?string $errorMsg;

    public ?string $fromEmail;

    public ?string $fromName;

    public ?string $toEmail;

    public ?string $toName;

    public ?string $subject;

    public ?string $content;

    public ?bool $copySent;

    public ?array $attachments;

    public function __construct(mixed $parameters = null)
    {
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (! is_array($parameters)) {
            $parameters = [];
        }

        $this->id = $parameters['id'] ?? null;
        $this->status = $parameters['status'] ?? null;
        $this->sentDate = $parameters['sent_date'] ?? null;
        $this->errorsCount = $parameters['errors_count'] ?? null;
        $this->errorMsg = $parameters['error_msg'] ?? null;
        $this->fromEmail = $parameters['from_email'] ?? null;
        $this->fromName = $parameters['from_name'] ?? null;
        $this->toEmail = $parameters['to_email'] ?? null;
        $this->toName = $parameters['to_name'] ?? null;
        $this->subject = $parameters['subject'] ?? null;
        $this->content = $parameters['content'] ?? null;
        $this->copySent = $parameters['copy_sent'] ?? null;
        $this->attachments = $parameters['attachments'] ?? null;
    }
}
