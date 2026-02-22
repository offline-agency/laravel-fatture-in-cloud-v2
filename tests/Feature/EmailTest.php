<?php

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Email;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Email\Email as EmailEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Email\EmailList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;

describe('Email', function () {
    it('lists emails', function () {
        Http::fake([
            'c/*/emails' => Http::response([
                'data' => [
                    [
                        'id' => 1,
                        'status' => 'sent',
                        'sent_date' => '2024-01-01',
                        'from_email' => 'from@example.com',
                        'to_email' => 'to@example.com',
                        'subject' => 'Test Subject',
                    ],
                    [
                        'id' => 2,
                        'status' => 'failed',
                        'sent_date' => '2024-01-02',
                        'from_email' => 'from@example.com',
                        'to_email' => 'other@example.com',
                        'subject' => 'Another Subject',
                    ],
                ],
            ], 200),
        ]);

        $api = new Email();
        $response = $api->list();

        expect($response)->toBeInstanceOf(EmailList::class)
            ->getItems()->toBeArray()->toHaveCount(2)
            ->getItems()->{0}->toBeInstanceOf(EmailEntity::class);
    });

    it('checks if email list has items', function () {
        Http::fake([
            'c/*/emails' => Http::response([
                'data' => [
                    ['id' => 1, 'status' => 'sent'],
                ],
            ], 200),
        ]);

        $api = new Email();
        $response = $api->list();

        expect($response->hasItems())->toBeTrue();
    });

    it('checks if email list is empty', function () {
        Http::fake([
            'c/*/emails' => Http::response([
                'data' => [],
            ], 200),
        ]);

        $api = new Email();
        $response = $api->list();

        expect($response->hasItems())->toBeFalse();
    });

    it('handles error on list emails', function () {
        Http::fake([
            'c/*/emails' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Email();
        $response = $api->list();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('maps email fields correctly', function () {
        Http::fake([
            'c/*/emails' => Http::response([
                'data' => [
                    [
                        'id' => 42,
                        'status' => 'sent',
                        'sent_date' => '2024-06-01',
                        'errors_count' => '0',
                        'error_msg' => null,
                        'from_email' => 'sender@example.com',
                        'from_name' => 'Sender',
                        'to_email' => 'recipient@example.com',
                        'to_name' => 'Recipient',
                        'subject' => 'Invoice #1',
                        'copy_sent' => false,
                    ],
                ],
            ], 200),
        ]);

        $api = new Email();
        $response = $api->list();

        $email = $response->getItems()[0];

        expect($email->id)->toBe(42)
            ->and($email->status)->toBe('sent')
            ->and($email->fromEmail)->toBe('sender@example.com')
            ->and($email->toEmail)->toBe('recipient@example.com')
            ->and($email->subject)->toBe('Invoice #1');
    });
});
