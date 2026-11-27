<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Webhook\WebhookSubscription as WebhookEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Webhook\WebhookSubscriptionList;

/**
 * @see https://developers.fattureincloud.it/api-reference#tag/Webhooks
 */
class Webhook extends Api
{
    public function list(): WebhookSubscriptionList|Error
    {
        $response = $this->get(
            'c/'.$this->companyId.'/webhooks/subscriptions',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $webhooks = $response->data;

        return new WebhookSubscriptionList($webhooks);
    }

    public function detail(string $subscriptionId): WebhookEntity|Error
    {
        $response = $this->get(
            'c/'.$this->companyId.'/webhooks/subscriptions/'.$subscriptionId,
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $webhook = $response->data->data;

        return new WebhookEntity($webhook);
    }

    public function delete(string $subscriptionId): string|Error
    {
        $response = $this->destroy(
            'c/'.$this->companyId.'/webhooks/subscriptions/'.$subscriptionId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Webhook subscription deleted';
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function create(array $body = []): WebhookEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.sink' => 'required',
            'data.types' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->companyId.'/webhooks/subscriptions',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $webhook = $response->data->data;

        return new WebhookEntity($webhook);
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function edit(string $subscriptionId, array $body = []): WebhookEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.sink' => 'required',
            'data.types' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            'c/'.$this->companyId.'/webhooks/subscriptions/'.$subscriptionId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $webhookResponse = $response->data->data;

        return new WebhookEntity($webhookResponse);
    }
}
