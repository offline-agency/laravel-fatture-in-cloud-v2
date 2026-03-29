<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Email;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class Email
{
    use CastsFromMixed;

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

    /** @var array<mixed>|null */
    public ?array $attachments;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->id = self::nullableInt($parameters, 'id');
        $this->status = self::nullableString($parameters, 'status');
        $this->sentDate = self::nullableString($parameters, 'sent_date');
        $this->errorsCount = self::nullableString($parameters, 'errors_count');
        $this->errorMsg = self::nullableString($parameters, 'error_msg');
        $this->fromEmail = self::nullableString($parameters, 'from_email');
        $this->fromName = self::nullableString($parameters, 'from_name');
        $this->toEmail = self::nullableString($parameters, 'to_email');
        $this->toName = self::nullableString($parameters, 'to_name');
        $this->subject = self::nullableString($parameters, 'subject');
        $this->content = self::nullableString($parameters, 'content');
        $this->copySent = self::nullableBool($parameters, 'copy_sent');
        $this->attachments = self::nullableArray($parameters, 'attachments');
    }
}
