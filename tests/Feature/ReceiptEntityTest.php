<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Receipt;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\Receipt as ReceiptEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptPagination;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceiptFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class ReceiptEntityTest extends TestCase
{
    // list

    public function test_list_receipts()
    {
        Http::fake([
            '/c/'.$company_id.'/receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeList()
            ),
        ]);

        $receipts = new Receipt();
        $response = $receipts->list();

        $this->assertInstanceOf(ReceiptList::class, $response);
        $this->assertInstanceOf(ReceiptPagination::class, $response->getPagination());
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(ReceiptEntity::class, $response->getItems()[0]);
    }

    public function test_list_receipt_has_receipts_method()
    {
        Http::fake([
            'receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeList()
            ),
        ]);

        $receipts = new Receipt();
        $response = $receipts->list();

        $this->assertTrue($response->hasItems());
    }

    public function test_empty_list_receipts_has_receipts_method()
    {
        Http::fake([
            'receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeList()
            ),
        ]);

        $receipts = new Receipt();
        $response = $receipts->list();

        $this->assertFalse($response->hasItems());
    }

    public function test_error_on_list_receipts()
    {
        Http::fake([
            '/c/'.company_id.'/receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeList(),
                401
            ),
        ]);

        $receipts = new Receipt();
        $response = $receipts->list();

        $this->assertInstanceOf(Error::class, $response);
    }

    // pagination

    public function test_go_to_receipt_next_page()
    {
        $receipt_list = new ReceiptList(json_decode(
            (new ReceiptFakeResponse())->getReceiptsFakeList([
                'next_page_url' => 'https://fake_url/entity?per_page=10&page=2',
            ])
        ));

        Http::fake([
            'receipts?per_page=10&page=2' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeList()
            ),
        ]);

        $next_page_response = $receipt_list->getPagination()->goToNextPage();

        $this->assertInstanceOf(ReceiptList::class, $next_page_response);
    }

    public function test_go_to_receipt_prev_page()
    {
        $receipt_list = new ReceiptList(json_decode(
            (new ReceiptFakeResponse())->getReceiptsFakeList([
                'prev_page_url' => 'https://fake_url/entity?per_page=10&page=1',
            ])
        ));

        Http::fake([
            'receipts?per_page=10&page=1' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeList()
            ),
        ]);

        $prev_page_response = $receipt_list->getPagination()->goToPrevPage();

        $this->assertInstanceOf(ReceiptList::class, $prev_page_response);
    }

    public function test_go_to_receipt_first_page()
    {
        $receipt_list = new ReceiptList(json_decode(
            (new ReceiptFakeResponse())->getReceiptsFakeList([
                'first_page_url' => 'https://fake_url/entity?per_page=10&page=1',
            ])
        ));

        Http::fake([
            'receipts?per_page=10&page=1' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeList()
            ),
        ]);

        $first_page_response = $receipt_list->getPagination()->goToFirstPage();

        $this->assertInstanceOf(ReceiptList::class, $first_page_response);
    }

    public function test_go_to_receipt_last_page()
    {
        $receipt_list = new ReceiptList(json_decode(
            (new ReceiptFakeResponse())->getReceiptsFakeList([
                'last_page_url' => 'https://fake_url/entity?per_page=10&page=2',
            ])
        ));

        Http::fake([
            'receipts?per_page=10&page=2' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeList()
            ),
        ]);

        $last_page_response = $receipt_list->getPagination()->goToLastPage();

        $this->assertInstanceOf(ReceiptList::class, $last_page_response);
    }

    // single

    public function test_detail_receipt()
    {
        $receipt_id = 1;

        Http::fake([
            'receipts/'.$receipt_id => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeDetail()
            ),
        ]);

        $receipt = new Receipt();
        $response = $receipt->detail($receipt_id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceiptEntity::class, $response);
    }

    public function test_delete_receipt()
    {
        $receipt_id = 1;

        Http::fake([
            'receipts/'.$receipt_id => Http::response(),
        ]);

        $receipt = new Receipt();
        $response = $receipt->delete($receipt_id);

        $this->assertEquals('Receipt deleted', $response);
    }

    // create

    public function test_create_receipt()
    {
        $receipt_name = 'Test';

        Http::fake([
            'receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeDetail([
                    'name' => $receipt_name,
                ])
            ),
        ]);

        $receipt = new Receipt();
        $response = $receipt->create([
            'data' => [
                'name' => $receipt_name,
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceiptEntity::class, $response);
    }

    public function test_validation_error_on_create_issued_document()
    {
        $receipt = new Receipt();
        $response = $receipt->create([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $receipt = new Receipt();
        $response = $receipt->create([
            'data' => [
                'net_price' => 100,
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.name', $response->messages());
        $this->assertArrayHasKey('data.code', $response->messages());
        $this->assertArrayHasKey('data.description', $response->messages());
    }

    // edit

    public function test_edit_receipt()
    {
        $document_id = 1;
        $receipt_name = 'Test Updated';

        Http::fake([
            'receipts/'.$document_id => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeDetail([
                    'id' => $document_id,
                    'name' => $receipt_name,
                ])
            ),
        ]);

        $receipt = new Receipt();
        $response = $receipt->edit($document_id, [
            'data' => [
                'name' => $receipt_name,
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceiptEntity::class, $response);
    }

    public function test_validation_error_on_update_issued_document()
    {
        $receipt_id = 1;

        $receipt = new Receipt();
        $response = $receipt->edit($receipt_id, []);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $receipt = new Receipt();
        $response = $receipt->edit($receipt_id, [
            'data' => [
                'net_price' => 100,
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.name', $response->messages());
        $this->assertArrayHasKey('data.code', $response->messages());
        $this->assertArrayHasKey('data.description', $response->messages());
    }
}
