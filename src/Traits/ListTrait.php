<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Traits;

use OfflineAgency\LaravelFattureInCloudV2\Api\Api;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;

/** @phpstan-require-extends Api */
trait ListTrait
{
    /**
     * @return array<int|string, mixed>
     */
    public function getQueryParams(string $url): array
    {
        $query = parse_url($url, PHP_URL_QUERY);

        if (! is_string($query)) {
            return [];
        }

        parse_str($query, $queryParams);

        return $queryParams;
    }

    /**
     * @param  array<string>  $validateAdditionalData
     * @param  array<int|string, mixed>  $additionalData
     * @param  array<mixed>  $accumulated
     * @return array<mixed>|Error
     */
    private function getAll(
        array $validateAdditionalData = [],
        ?string $url = null,
        array $additionalData = [],
        array $accumulated = []
    ): array|Error {
        $additionalData = $this->data($additionalData, $validateAdditionalData);

        $response = $this->get((string) $url, $additionalData);

        if (! $response->success) {
            return new Error($response->data);
        }

        $responseData = $response->data;

        $accumulated = array_merge($accumulated, (array) $responseData->data);

        if (! isset($responseData->next_page_url)) {
            return $accumulated;
        }

        $queryParams = $this->getQueryParams($responseData->next_page_url);

        return $this->getAll($validateAdditionalData, $url, $queryParams, $accumulated);
    }
}
