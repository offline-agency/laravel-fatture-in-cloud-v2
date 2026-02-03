<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ArchiveDocument\TestArchiveDocument;
use PHPUnit\Framework\TestCase;

class ArchiveDocumentsTest extends TestCase
{
    public function testGetFakeArchiveDocument()
    {
        $fakeArchiveDocument = new TestArchiveDocument();

        $result = $fakeArchiveDocument->getFakeArchiveDocument([
            'id' => 123,
            'date' => '2024-06-06',
            'description' => 'Document description',
            'attachment_url' => 'https://example.com/document.pdf',
            'category' => 'General',
            'current_page' => 1,
            'first_page_url' => 'https://example.com/api/archive-document?page=1',
            'from' => 1,
            'last_page' => 5,
            'last_page_url' => 'https://example.com/api/archive-document?page=5',
            'next_page_url' => 'https://example.com/api/archive-document?page=2',
            'path' => 'https://example.com/api/archive-document',
            'per_page' => 5,
            'prev_page_url' => null,
            'to' => 5,
            'total' => 25,
            'data' => [
                [
                    'id' => 123,
                    'date' => '2024-06-06',
                    'description' => 'Document description',
                    'attachment_url' => 'https://example.com/document.pdf',
                    'category' => 'General',
                ],
                [
                    'id' => 124,
                    'date' => '2024-06-07',
                    'description' => 'Another document',
                    'attachment_url' => 'https://example.com/another-document.pdf',
                    'category' => 'General',
                ],
            ],
        ]);

        $this->assertNotEmpty($result['data']);
        $this->assertTrue(isset($result['data'][0]['id']));
        $this->assertEquals(1, $result['data'][0]['id']);


        $this->assertNotEmpty($result['data']);
        $this->assertTrue(isset($result['data'][0]['date']));
        $this->assertEquals('2024-06-06', $result['data'][0]['date']);

        $this->assertNotEmpty($result['data']);
        $this->assertTrue(isset($result['data'][0]['description']));
        $this->assertEquals('Sample document', $result['data'][0]['description']);

        $this->assertNotEmpty($result['data']);
        $this->assertTrue(isset($result['data'][0]['attachment_url']));
        $this->assertEquals('https://example.com/document.pdf', $result['data'][0]['attachment_url']);

        $this->assertNotEmpty($result['data']);
        $this->assertTrue(isset($result['data'][0]['category']));
        $this->assertEquals('General', $result['data'][0]['category']);

        $this->assertEquals(1, $result['current_page']);
        $this->assertEquals('https://example.com/api/archive-document?page=1', $result['first_page_url']);
        $this->assertEquals(1, $result['from']);
        $this->assertEquals(5, $result['last_page']);
        $this->assertEquals('https://example.com/api/archive-document?page=5', $result['last_page_url']);
        $this->assertEquals('https://example.com/api/archive-document?page=2', $result['next_page_url']);
        $this->assertEquals('https://example.com/api/archive-document', $result['path']);
        $this->assertEquals(5, $result['per_page']);
        $this->assertNull($result['prev_page_url']);
        $this->assertEquals(5, $result['to']);
        $this->assertEquals(25, $result['total']);
        $this->assertCount(1, $result['data']);
    }
}
