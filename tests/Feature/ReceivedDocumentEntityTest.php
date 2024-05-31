<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Api\ReceivedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocuments\ReceivedDocument as ReceivedDocumentsEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocuments\ReceivedDocumentLIst;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocuments\ReceivedDocumentPagination;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocuments\ReceivedDocumentsGetExistingTotals;
use OfflineAgency\LaravelFattureInCloudV2\Entities\ReceivedDocuments\ReceivedDocumentsPreCreateInfo;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocumentFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ReceivedDocumentFakeResponse;
use OfflineAgency\LaravelFattureInCloudV2\Tests\TestCase;

class ReceivedDocumentEntityTest extends TestCase
{
    //List

    public function test_list_received_documents()
    {
        $type = 'invoice';

        Http::fake([
            'received_documents?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeList()
            ),
        ]);

        $received_documents = new ReceivedDocument();
        $response = $received_documents->list($type);

        $this->assertInstanceOf(ReceivedDocumentLIst::class, $response);
        $this->assertInstanceOf(ReceivedDocumentPagination::class, $response->getPagination());
        $this->assertIsArray($response->getItems());
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(ReceivedDocumentsEntity::class, $response->getItems()[0]);
    }

    public function test_all_documents()
    {
        $type = 'invoice';

        Http::fake([
            'received_documents?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeAll()
            ),
        ]);

        $received_document = new ReceivedDocument();
        $response = $received_document->all($type);

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
        $this->assertInstanceOf(ReceivedDocumentsEntity::class, $response[0]);
    }

    public function test_error_on_all_documents()
    {
        $type = 'invoice';

        Http::fake([
            'received_documents?type='.$type => Http::response(
                (new ReceivedDocumentFakeResponse())->getReceivedDocumentFakeError(),
                401
            ),
        ]);

        $received_documents = new IssuedDocument();
        $response = $received_documents->all($type);

        $this->assertInstanceOf(Error::class, $response);
    }
 // ARRIVATO ALLA 78 IN CONFRONTO ALLA public function test_list_issued_documenta_has_issued_documents_method()
}
