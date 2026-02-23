<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Webhook;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Webhook\WebhookSubscription as WebhookEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Webhook\WebhookSubscriptionList;

describe('Webhook', function () {
    it('lists webhook subscriptions', function () {
        Http::fake([
            'c/*/webhooks/subscriptions' => Http::response([
                'data' => [
                    ['id' => 'sub_1', 'sink' => 'https://example.com/hook1', 'verified' => true, 'types' => ['it.fattureincloud.api.v2.client.created']],
                    ['id' => 'sub_2', 'sink' => 'https://example.com/hook2', 'verified' => false, 'types' => ['it.fattureincloud.api.v2.invoice.created']],
                ],
            ], 200),
        ]);

        $api = new Webhook();
        $response = $api->list();

        expect($response)->toBeInstanceOf(WebhookSubscriptionList::class)
            ->getItems()->toBeArray()->toHaveCount(2)
            ->getItems()->{0}->toBeInstanceOf(WebhookEntity::class);
    });

    it('checks if webhook list has items', function () {
        Http::fake([
            'c/*/webhooks/subscriptions' => Http::response([
                'data' => [
                    ['id' => 'sub_1', 'sink' => 'https://example.com/hook', 'verified' => true, 'types' => []],
                ],
            ], 200),
        ]);

        $api = new Webhook();
        $response = $api->list();

        expect($response->hasItems())->toBeTrue();
    });

    it('checks if webhook list is empty', function () {
        Http::fake([
            'c/*/webhooks/subscriptions' => Http::response([
                'data' => [],
            ], 200),
        ]);

        $api = new Webhook();
        $response = $api->list();

        expect($response->hasItems())->toBeFalse();
    });

    it('handles error on list webhook subscriptions', function () {
        Http::fake([
            'c/*/webhooks/subscriptions' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Webhook();
        $response = $api->list();

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('gets webhook subscription detail', function () {
        $subscriptionId = 'sub_abc123';

        Http::fake([
            'c/*/webhooks/subscriptions/'.$subscriptionId => Http::response([
                'data' => [
                    'id' => $subscriptionId,
                    'sink' => 'https://example.com/hook',
                    'verified' => true,
                    'types' => ['it.fattureincloud.api.v2.client.created'],
                ],
            ], 200),
        ]);

        $api = new Webhook();
        $response = $api->detail($subscriptionId);

        expect($response)->toBeInstanceOf(WebhookEntity::class)
            ->and($response->id)->toBe($subscriptionId);
    });

    it('handles error on webhook subscription detail', function () {
        Http::fake([
            'c/*/webhooks/subscriptions/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Webhook();
        $response = $api->detail('nonexistent');

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('deletes a webhook subscription', function () {
        $subscriptionId = 'sub_abc123';

        Http::fake([
            'c/*/webhooks/subscriptions/'.$subscriptionId => Http::response(null, 200),
        ]);

        $api = new Webhook();
        $response = $api->delete($subscriptionId);

        expect($response)->toBe('Webhook subscription deleted');
    });

    it('creates a webhook subscription', function () {
        Http::fake([
            'c/*/webhooks/subscriptions' => Http::response([
                'data' => [
                    'id' => 'sub_new',
                    'sink' => 'https://example.com/new-hook',
                    'verified' => false,
                    'types' => ['it.fattureincloud.api.v2.client.created'],
                ],
            ], 200),
        ]);

        $api = new Webhook();
        $response = $api->create([
            'data' => [
                'sink' => 'https://example.com/new-hook',
                'types' => ['it.fattureincloud.api.v2.client.created'],
            ],
        ]);

        expect($response)->toBeInstanceOf(WebhookEntity::class)
            ->and($response->id)->toBe('sub_new')
            ->and($response->sink)->toBe('https://example.com/new-hook');
    });

    it('validates on create webhook subscription', function () {
        $api = new Webhook();
        $response = $api->create([]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('validates sink on create webhook subscription', function () {
        $api = new Webhook();
        $response = $api->create(['data' => ['types' => ['it.fattureincloud.api.v2.client.created']]]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.sink');
    });

    it('validates types on create webhook subscription', function () {
        $api = new Webhook();
        $response = $api->create(['data' => ['sink' => 'https://example.com/hook']]);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data.types');
    });

    it('edits a webhook subscription', function () {
        $subscriptionId = 'sub_abc123';

        Http::fake([
            'c/*/webhooks/subscriptions/'.$subscriptionId => Http::response([
                'data' => [
                    'id' => $subscriptionId,
                    'sink' => 'https://example.com/updated-hook',
                    'verified' => true,
                    'types' => ['it.fattureincloud.api.v2.invoice.created'],
                ],
            ], 200),
        ]);

        $api = new Webhook();
        $response = $api->edit($subscriptionId, [
            'data' => [
                'sink' => 'https://example.com/updated-hook',
                'types' => ['it.fattureincloud.api.v2.invoice.created'],
            ],
        ]);

        expect($response)->toBeInstanceOf(WebhookEntity::class)
            ->and($response->sink)->toBe('https://example.com/updated-hook');
    });

    it('validates on edit webhook subscription', function () {
        $api = new Webhook();
        $response = $api->edit('sub_abc123', []);

        expect($response)->toBeInstanceOf(MessageBag::class)
            ->messages()->toHaveKey('data');
    });

    it('handles error on create webhook subscription', function () {
        Http::fake([
            'c/*/webhooks/subscriptions' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Webhook();
        $response = $api->create([
            'data' => [
                'sink' => 'https://example.com/hook',
                'types' => ['it.fattureincloud.api.v2.client.created'],
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('handles error on delete webhook subscription', function () {
        Http::fake([
            'c/*/webhooks/subscriptions/*' => Http::response([
                'code' => 'NOT_FOUND',
                'message' => 'Not found',
            ], 404),
        ]);

        $api = new Webhook();
        $response = $api->delete('nonexistent');

        expect($response)->toBeInstanceOf(Error::class);
    });

    it('handles error on edit webhook subscription', function () {
        Http::fake([
            'c/*/webhooks/subscriptions/*' => Http::response([
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $api = new Webhook();
        $response = $api->edit('sub_abc123', [
            'data' => [
                'sink' => 'https://example.com/hook',
                'types' => ['it.fattureincloud.api.v2.client.created'],
            ],
        ]);

        expect($response)->toBeInstanceOf(Error::class);
    });
});
