<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

class PaginationFakeResponse extends FakeResponse
{
    public function getPaginationFake(
        array $params = []
    ): array
    {
        return [
            'current_page' => $this->value($params, 'current_page', 1),
            'first_page_url' => $this->value($params, 'first_page_url', 'https://fake_url/entity?per_page=10&page=1'),
            'from' => $this->value($params, 'from', 1),
            'last_page' => $this->value($params, 'last_page', 2),
            'last_page_url' => $this->value($params, 'last_page_url', 'https://fake_url/entity?per_page=10&page=2'),
            'next_page_url' => $this->value($params, 'next_page_url', 'https://fake_url/entity?per_page=10&page=2'),
            'path' => $this->value($params, 'path', 'fake_path'),
            'per_page' => $this->value($params, 'per_page', 10),
            'prev_page_url' => $this->value($params, 'prev_page_url', null),
            'to' => $this->value($params, 'to', 10),
            'total' => $this->value($params, 'total', 15)
        ];
    }
}
