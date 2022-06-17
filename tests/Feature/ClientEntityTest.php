<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Client;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\ClientPagination;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ClientFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class ClientEntityTest extends TestCase
{
    // list

    public function test_list_clients()
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

    public function test_error_on_list_clients()
    {
        Http::fake([
            'entities/clients' => Http::response(
                (new ClientFakeResponse())->getClientFakeError(),
                401
            ),
        ]);

        $clients = new Client();
        $response = $clients->list();

        $this->assertInstanceOf(Error::class, $response);
    }

    // pagination

    public function test_go_to_client_next_page()
    {
        $product_list = new ClientList(json_decode(
            (new ClientFakeResponse())->getClientsFakeList([
                'next_page_url' => 'https://fake_url/entities/clients?per_page=10&page=2',
            ])
        ));

        Http::fake([
            'entities/clients?per_page=10&page=2' => Http::response(
                (new ClientFakeResponse())->getClientsFakeList()
            ),
        ]);

        $next_page_response = $product_list->getPagination()->goToNextPage();

        $this->assertInstanceOf(ClientList::class, $next_page_response);
    }

    public function test_go_to_client_prev_page()
    {
        $product_list = new ClientList(json_decode(
            (new ClientFakeResponse())->getClientsFakeList([
                'prev_page_url' => 'https://fake_url/entities/clients?per_page=10&page=1',
            ])
        ));

        Http::fake([
            'entities/clients?per_page=10&page=1' => Http::response(
                (new ClientFakeResponse())->getClientsFakeList()
            ),
        ]);

        $prev_page_response = $product_list->getPagination()->goToPrevPage();

        $this->assertInstanceOf(ClientList::class, $prev_page_response);
    }

    public function test_go_to_client_first_page()
    {
        $product_list = new ClientList(json_decode(
            (new ClientFakeResponse())->getClientsFakeList([
                'first_page_url' => 'https://fake_url/entities/clients?per_page=10&page=1',
            ])
        ));

        Http::fake([
            'entities/clients?per_page=10&page=1' => Http::response(
                (new ClientFakeResponse())->getClientsFakeList()
            ),
        ]);

        $first_page_response = $product_list->getPagination()->goToFirstPage();

        $this->assertInstanceOf(ClientList::class, $first_page_response);
    }

    public function test_go_to_client_last_page()
    {
        $product_list = new ClientList(json_decode(
            (new ClientFakeResponse())->getClientsFakeList([
                'last_page_url' => 'https://fake_url/entities/clients?per_page=10&page=2',
            ])
        ));

        Http::fake([
            'entities/clients?per_page=10&page=2' => Http::response(
                (new ClientFakeResponse())->getClientsFakeList()
            ),
        ]);

        $last_page_response = $product_list->getPagination()->goToLastPage();

        $this->assertInstanceOf(ClientList::class, $last_page_response);
    }

    // single

    public function test_detail_client()
    {
        $client_id = 1;

        Http::fake([
            'entities/clients/'.$client_id => Http::response(
                (new ClientFakeResponse())->getClientFakeDetail()
            ),
        ]);

        $client = new Client();
        $response = $client->detail($client_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ClientEntity::class, $response);
    }

    public function test_delete_client()
    {
        $client_id = 1;

        Http::fake([
            'entities/clients/'.$client_id => Http::response(),
        ]);

        $client = new Client();
        $response = $client->delete($client_id);

        $this->assertEquals('Client deleted', $response);
    }

    // create

    public function test_create_client()
    {
        Http::fake([
            'entities/clients' => Http::response(
                (new ClientFakeResponse())->getClientFakeDetail()
            ),
        ]);

        $client = new Client();
        $response = $client->create([
            'data' => [
                'name' => 'Test'
            ]
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ClientEntity::class, $response);
    }

    public function test_validation_error_on_create_issued_document()
    {
        $client = new Client();
        $response = $client->create([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $client = new Client();
        $response = $client->create([
            'data' => [
                'code' => 'test'
            ]
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.name', $response->messages());
    }

    // client

    public function test_edit_client()
    {
        $client_id = 1;
        $client_name = 'Test Updated';

        Http::fake([
            'entities/clients/'.$client_id => Http::response(
                (new ClientFakeResponse())->getClientFakeDetail([
                    'name' => $client_name
                ])
            ),
        ]);

        $client = new Client();
        $response = $client->edit($client_id, [
            'data' => [
                'name' => $client_name
            ]
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ClientEntity::class, $response);
    }

    public function test_validation_error_on_edit_issued_document()
    {
        $client_id = 1;

        $client = new Client();
        $response = $client->edit($client_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $client = new Client();
        $response = $client->edit($client_id, [
            'data' => [
                'code' => 'test'
            ]
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.name', $response->messages());
    }
}
