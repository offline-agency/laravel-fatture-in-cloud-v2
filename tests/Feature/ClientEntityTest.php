<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Client;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientPagination;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ClientFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class ClientEntityTest extends TestCase
{
    public function test_list_issued_documents()
    {
        Http::fake([
            'entities/clients' => Http::response(
                (new ClientFakeResponse())->getClientsFakeList()
            ),
        ]);

        $clients = new Client();
        $response = $clients->list();

        $this->assertInstanceOf(ClientList::class, $response);
        $this->assertInstanceOf(ClientPagination::class, $response->getPagination());
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(ClientEntity::class, $response->getItems()[0]);
    }
}
