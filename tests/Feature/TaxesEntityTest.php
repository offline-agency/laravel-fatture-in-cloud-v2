<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Taxes;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\Taxes as TaxesEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\TaxesList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Taxes\TaxesPagination;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\TaxesFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;


class TaxesEntityTest extends TestCase
{
    // list

    public function test_list_taxes()
    {
        $type = 'invoice';

        Http::fake([
            'taxes?type='.$type => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeList()
            ),
        ]);

        $taxes = new Taxes();
        $response = $taxes->list($type);

        $this->assertInstanceOf(TaxesList::class, $response);
        $this->assertInstanceOf(TaxesPagination::class, $response->getPagination());
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(TaxesEntity::class, $response->getItems()[0]);
    }

    public function test_all_documents()
    {
        $type = 'expense';

        Http::fake([
            'taxes?type='.$type => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeAll()
            ),
        ]);

        $taxes = new Taxes();
        $response = $taxes->all($type);

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
        $this->assertInstanceOf(TaxesEntity::class, $response[0]);
    }

    public function test_error_on_all_documents()
    {
        $type = 'expense';

        Http::fake([
            'taxes?type='.$type => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeError(),
                401
            ),
        ]);

        $taxes = new Taxes();
        $response = $taxes->all($type);

        $this->assertInstanceOf(Error::class, $response);
    }

    public function test_list_taxes_has_taxes_method()
    {
        $type = 'expense';

        Http::fake([
            'taxes?type='.$type => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeList()
            ),
        ]);

        $taxes = new Taxes();
        $response = $taxes->list($type);

        $this->assertTrue($response->hasItems());
    }

    public function test_empty_list_taxes_has_taxes_method()
    {
        $type = 'expense';

        Http::fake([
            'taxes?type='.$type => Http::response(
                (new TaxesFakeResponse())->getEmptyTaxesFakeList()
            ),
        ]);

        $taxes = new Taxes();
        $response = $taxes->list($type);

        $this->assertFalse($response->hasItems());
    }

    public function test_error_on_list_taxes()
    {
        $type = 'expense';

        Http::fake([
            'taxes?type='.$type => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeError(),
                401
            ),
        ]);

        $taxes = new Taxes();
        $response = $taxes->list($type);

        $this->assertInstanceOf(Error::class, $response);
    }

    // pagination

    public function test_query_parameters_parsing()
    {
        $taxes_pagination = new TaxesPagination((object) []);

        $query_params = $taxes_pagination->getParsedQueryParams('https://fake_url.com/entity?first=Lorem&type=document_type&second=Ipsum');

        $this->assertIsObject($query_params);

        $this->assertObjectHasProperty('type', $query_params);
        $this->assertObjectHasProperty('additional_data', $query_params);

        $this->assertEquals('document_type', $query_params->type);
        $this->assertIsArray($query_params->additional_data);
        $this->assertCount(2, $query_params->additional_data);
    }

    public function test_go_to_taxes_next_page()
    {
        $type = 'expense';

        $taxes_list = new TaxesList(json_decode(
            (new TaxesFakeResponse())->getTaxesFakeList([
                'next_page_url' => 'https://fake_url/taxes?type='.$type.'&per_page=10&page=2',
            ])
        ));

        Http::fake([
            'taxes?per_page=10&page=2&type='.$type => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeList()
            ),
        ]);

        $next_page_response = $taxes_list->getPagination()->goToNextPage();

        $this->assertInstanceOf(TaxesList::class, $next_page_response);
    }

    public function test_go_to_taxes_prev_page()
    {
        $type = 'expense';

        $taxes_list = new TaxesList(json_decode(
            (new TaxesFakeResponse())->getTaxesFakeList([
                'prev_page_url' => 'https://fake_url/taxes?type='.$type.'&per_page=10&page=1',
            ])
        ));

        Http::fake([
            'taxes?per_page=10&page=1&type='.$type => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeList()
            ),
        ]);

        $prev_page_response = $taxes_list->getPagination()->goToPrevPage();

        $this->assertInstanceOf(TaxesList::class, $prev_page_response);
    }

    public function test_go_to_taxes_first_page()
    {
        $type = 'expense';

        $taxes_list = new TaxesList(json_decode(
            (new TaxesFakeResponse())->getTaxesFakeList([
                'first_page_url' => 'https://fake_url/taxes?type='.$type.'&per_page=10&page=1',
            ])
        ));

        Http::fake([
            'taxes?per_page=10&page=1&type='.$type => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeList()
            ),
        ]);

        $first_page_response = $taxes_list->getPagination()->goToFirstPage();

        $this->assertInstanceOf(TaxesList::class, $first_page_response);
    }

    public function test_go_to_taxes_last_page()
    {
        $type = 'expense';

        $taxes_list = new TaxesList(json_decode(
            (new TaxesFakeResponse())->getTaxesFakeList([
                'last_page_url' => 'https://fake_url/taxes?type='.$type.'&per_page=10&page=2',
            ])
        ));

        Http::fake([
            'taxes?per_page=10&page=2&type='.$type => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeList()
            ),
        ]);

        $last_page_response = $taxes_list->getPagination()->goToLastPage();

        $this->assertInstanceOf(TaxesList::class, $last_page_response);
    }

    // single

    public function test_detail_taxes()
    {
        $document_id = 1;

        Http::fake([
            'taxes/'.$document_id => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeDetail()
            ),
        ]);

        $taxes = new Taxes();
        $response = $taxes->detail($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(TaxesEntity::class, $response);
    }

    public function test_bin_taxes()
    {
        $document_id = 1;

        Http::fake([
            'bin/taxes/'.$document_id => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeDetail()
            ),
        ]);

        $taxes = new Taxes();
        $response = $taxes->bin($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(TaxesEntity::class, $response);
    }

    public function test_delete_taxes()
    {
        $document_id = 1;

        Http::fake([
            'taxes/'.$document_id => Http::response(),
        ]);

        $taxes = new Taxes();
        $response = $taxes->delete($document_id);

        $this->assertEquals('Taxes deleted', $response);
    }

    public function test_taxes_bin_detail_from_detail()
    {
        $document_id = 1;

        Http::fake([
            'taxes/'.$document_id => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeDetail()
            ),
        ]);

        $taxes = new Taxes();
        $response = $taxes->binDetail($document_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(TaxesEntity::class, $response);
    }

    public function test_taxes_bin_detail_from_bin()
    {
        $document_id = 1;

        Http::fake([
            'taxes/'.$document_id => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeDetail()
            ),
        ]);

        Http::fake([
            'taxes/'.$document_id.'?fields=id' => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeErrorDetail(),
                401
            ),
        ]);

        $taxes = new Taxes();
        $response = $taxes->binDetail($document_id, [
            'fields' => 'id',
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(TaxesEntity::class, $response);
    }

    // create

    public function test_create_taxes()
    {
        $entity_name = 'Test S.R.L';

        Http::fake([
            'taxes' => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeDetail([
                    'entity' => [
                        'name' => $entity_name,
                    ],
                ])
            ),
        ]);

        $taxes = new Taxes();
        $response = $taxes->create([
            'data' => [
                'type' => 'expense',
                'entity' => [
                    'name' => $entity_name,
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(TaxesEntity::class, $response);
    }

    public function test_validation_error_on_create_taxes()
    {
        $taxes = new Taxes();
        $response = $taxes->create([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $taxes = new Taxes();
        $response = $taxes->create([
            'data' => [],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());
        $this->assertArrayHasKey('data.entity.name', $response->messages());

        $taxes = new Taxes();
        $response = $taxes->create([
            'data' => [
                'entity' => [
                    'name' => 'Test S.R.L.',
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.type', $response->messages());

        $taxes = new Taxes();
        $response = $taxes->create([
            'data' => [
                'type' => 'expense',
                'entity' => [],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.entity.name', $response->messages());
    }
    // edit

    public function test_edit_taxes()
    {
        $document_id = 1;
        $entity_name = 'Test S.R.L Updated';

        Http::fake([
            'taxes/'.$document_id => Http::response(
                (new TaxesFakeResponse())->getTaxesFakeDetail([
                    'entity' => [
                        'name' => $entity_name,
                    ],
                ])
            ),
        ]);

        $taxes = new Taxes();
        $response = $taxes->edit($document_id, [
            'data' => [
                'entity' => [
                    'name' => $entity_name,
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(TaxesEntity::class, $response);
    }

    public function test_validation_error_on_edit_taxes()
    {
        $document_id = 1;

        $taxes = new Taxes();
        $response = $taxes->edit($document_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $taxes = new Taxes();
        $response = $taxes->edit($document_id, [
            'data' => [],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());
        $this->assertArrayHasKey('data.entity.name', $response->messages());

        $taxes = new Taxes();
        $response = $taxes->edit($document_id, [
            'data' => [
                'entity' => [],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.entity.name', $response->messages());
    }

    public function test_delete_attachment_taxes()
    {
        $document_id = 1;

        Http::fake([
            'taxes/'.$document_id.'/attachment' => Http::response(),
        ]);

        $taxes = new Taxes();
        $response = $taxes->deleteAttachment($document_id);

        $this->assertEquals('Attachment deleted', $response);
    }

}
