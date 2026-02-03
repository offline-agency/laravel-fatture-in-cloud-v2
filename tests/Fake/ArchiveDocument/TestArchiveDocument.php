<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ArchiveDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class TestArchiveDocument extends FakeResponse
{
    public function getFakeArchiveDocument(array $params = []): array
    {
        return [
            'current_page' => $this->value($params, 'current_page', 1),
            'first_page_url' => $this->value($params, 'first_page_url', 'https://example.com?page=1'),
            'from' => $this->value($params, 'from', 1),
            'last_page' => $this->value($params, 'last_page', 1),
            'last_page_url' => $this->value($params, 'last_page_url', 'https://example.com?page=1'),
            'next_page_url' => $this->value($params, 'next_page_url', null),
            'path' => $this->value($params, 'path', 'https://example.com'),
            'per_page' => $this->value($params, 'per_page', 5),
            'prev_page_url' => $this->value($params, 'prev_page_url', null),
            'to' => $this->value($params, 'to', 5),
            'total' => $this->value($params, 'total', 10),
            'data' => [
                [
                    'id' => $this->value($params, 'data.id', 1),
                    'date' => $this->value($params, 'data.date', '2024-06-06'),
                    'description' => $this->value($params, 'data.description', 'Sample document'),
                    'attachment_url' => $this->value($params, 'data.attachment_url', 'https://example.com/document.pdf'),
                    'category' => $this->value($params, 'data.category', 'General'),
                ],
            ],
        ];
    }
}
