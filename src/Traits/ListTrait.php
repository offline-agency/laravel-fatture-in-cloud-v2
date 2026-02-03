<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Traits;

use Illuminate\Support\Arr;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;

trait ListTrait
{
    /** @var array<mixed> */
    private array $all = [];

    public function hasItems(): bool
    {
        return count($this->getItems()) > 0;
    }

    public function getQueryParams(string $url): array
    {
        $parsedUrl = parse_url($url);
        $queryString = Arr::get($parsedUrl, 'query', '');

        parse_str($queryString, $queryParams);

        return $queryParams;
    }

    /**
     * @return array<mixed>|Error
     */
    private function getAll(
        array $validateAdditionalData = [],
        ?string $url = null,
        array $additionalData = []
    ): array|Error {
        $additionalData = $this->data($additionalData, $validateAdditionalData);

        /** @var object $response */
        $response = $this->get((string) $url, $additionalData);

        if (!$response->success) {
            return new Error($response->data);
        }

        $responseData = $response->data;

        $this->all = array_merge($this->all, (array) $responseData->data);

        if (!isset($responseData->next_page_url)) {
            return $this->all;
        }

        $queryParams = $this->getQueryParams($responseData->next_page_url);

        return $this->getAll($validateAdditionalData, $url, $queryParams);
    }
}
