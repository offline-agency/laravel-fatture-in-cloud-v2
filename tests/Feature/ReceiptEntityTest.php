<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\Receipt;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\Receipt as ReceiptEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptMonthlyTotals;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptPagination;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptPreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceiptFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class ReceiptEntityTest extends TestCase
{
    // list

    public function test_list_receipts()
    {
        Http::fake([
            'receipts' => Http::response(
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

    public function test_all_receipts()
    {
        Http::fake([
            'receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeAll()
            ),
        ]);

        $receipts = new Receipt();
        $response = $receipts->all();

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
        $this->assertInstanceOf(ReceiptEntity::class, $response[0]);
    }

    public function test_error_on_all_receipts()
    {
        Http::fake([
            'receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptFakeError(),
                401
            ),
        ]);

        $receipts = new Receipt();
        $response = $receipts->all();

        $this->assertInstanceOf(Error::class, $response);
    }

    public function test_list_receipts_has_receipts_method()
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
                (new ReceiptFakeResponse())->getEmptyReceiptFakeList()
            ),
        ]);

        $receipts = new Receipt();
        $response = $receipts->list();

        $this->assertFalse($response->hasItems());
    }

    public function test_error_on_list_receipts()
    {
        Http::fake([
            'receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptFakeError(),
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
                'next_page_url' => 'https://fake_url/receipts?per_page=10&page=2',
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
                'prev_page_url' => 'https://fake_url/receipts?per_page=10&page=1',
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
                'first_page_url' => 'https://fake_url/receipts?per_page=10&page=1',
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
                'last_page_url' => 'https://fake_url/receipts?per_page=10&page=2',
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
        Http::fake([
            'receipts' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeDetail()
            ),
        ]);

        $receipt = new Receipt();
        $response = $receipt->create([
            'data' => [
                'date' => Carbon::now()->format('Y-m-d'),
                'type' => 'sales_receipt',
                'payment_account' => [
                    'name' => 'fake',
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceiptEntity::class, $response);
    }

    public function test_validation_error_on_create_receipt()
    {
        $receipt = new Receipt();
        $response = $receipt->create([]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data', $response->messages());

        $receipt = new Receipt();
        $response = $receipt->create([
            'data' => [
                'number' => 1,
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.date', $response->messages());
        $this->assertArrayHasKey('data.type', $response->messages());
        $this->assertArrayHasKey('data.payment_account', $response->messages());
        $this->assertArrayHasKey('data.payment_account.name', $response->messages());
    }

    // edit

    public function test_edit_receipt()
    {
        $receipt_id = 1;

        Http::fake([
            'receipts/'.$receipt_id => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeDetail(),
            ),
        ]);

        $receipt = new Receipt();
        $response = $receipt->edit($receipt_id, [
            'data' => [
                'date' => Carbon::now()->format('Y-m-d'),
                'type' => 'sales_receipt',
                'payment_account' => [
                    'name' => 'fake',
                ],
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceiptEntity::class, $response);
    }

    public function test_validation_error_on_edit_receipt()
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
                'number' => 1,
            ],
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('data.date', $response->messages());
        $this->assertArrayHasKey('data.type', $response->messages());
        $this->assertArrayHasKey('data.payment_account', $response->messages());
        $this->assertArrayHasKey('data.payment_account.name', $response->messages());
    }

    // pre create info

    public function test_pre_create_info_receipt()
    {
        Http::fake([
            'receipts/info' => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakePreCreateInfo()
            ),
        ]);

        $receipt = new Receipt();
        $response = $receipt->preCreateInfo();

        $this->assertNotNull($response);
        $this->assertInstanceOf(ReceiptPreCreateInfo::class, $response);
    }

    // monthly totals

    public function test_monthly_totals_receipt()
    {
        $type = 'till_receipt';
        $year = 2022;

        Http::fake([
            'receipts/monthly_totals?type='.$type.'&year='.$year => Http::response(
                (new ReceiptFakeResponse())->getReceiptsFakeMonthlyTotals()
            ),
        ]);

        $receipt = new Receipt();
        $response = $receipt->monthlyTotals($type, $year);

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
        $this->assertInstanceOf(ReceiptMonthlyTotals::class, $response[0]);
    }

    public function test_validation_error_on_create_issued_document()
    {
        $receipt = new Receipt();
        $response = $receipt->monthlyTotals('fake_type', 2022);

        $this->assertNotNull($response);
        $this->assertInstanceOf(MessageBag::class, $response);
        $this->assertArrayHasKey('type', $response->messages());
    }
}
