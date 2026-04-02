<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Webhook;

readonly class WebhookSubscriptionList
{
    /**
     * @var array<WebhookSubscription>
     */
    public array $items;

    public function __construct(\stdClass $webhookResponse)
    {
        $this->items = array_map(function ($webhook) {
            return new WebhookSubscription($webhook);
        }, $webhookResponse->data);
    }

    /**
     * @return array<WebhookSubscription>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }
}
