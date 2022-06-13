<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Arr;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class PaginationTest extends TestCase
{
    public function test_is_single_page_function()
    {
        $pagination = new Pagination((object) [
            'total' => 1,
            'per_page' => 10,
        ]);

        $this->assertTrue($pagination->isSinglePage());

        $pagination = new Pagination((object) [
            'total' => 15,
            'per_page' => 10,
        ]);

        $this->assertFalse($pagination->isSinglePage());
    }

    public function test_params_retrieving()
    {
        $pagination = new Pagination((object) []);

        $query_params = $pagination->getQueryParams('https://fake_url.com/entity?first=Lorem&second=Ipsum');

        $this->assertIsArray($query_params);

        $this->assertArrayHasKey('first', $query_params);
        $this->assertArrayHasKey('second', $query_params);

        $this->assertEquals('Lorem', Arr::get($query_params, 'first'));
        $this->assertEquals('Ipsum', Arr::get($query_params, 'second'));
    }
}
