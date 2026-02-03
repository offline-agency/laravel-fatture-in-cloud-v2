<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use Illuminate\Http\Request;
use OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook\CashbookEntries;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class Cashbooks extends Api
{
    use ListTrait;

    const CASHBOOK_KINDS = [
        'cashbook',
        'issued_document',
        'received_document',
        'tax',
        'receipt',
    ];

    public function listCashBookEntry(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'nullable|string',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'kind' => 'required|in:cashbook,issued_document,received_document,tax,receipt',
            'type' => 'nullable|in:in,out',
            'entity_name' => 'nullable|string',

            'document.id' => 'nullable|int',
            'document.type' => 'nullable|string',
            'document.path' => 'nullable|string',

            'amount_in' => 'nullable|numeric',

            'payment_account_in.id' => 'nullable|int',
            'payment_account_in.name' => 'nullable|string',
            'payment_account_in.type' => 'nullable|in:standard,bank',
            'payment_account_in.iban' => 'nullable|string',
            'payment_account_in.sia' => 'nullable|string',
            'payment_account_in.cuc' => 'nullable|string',
            'payment_account_in.virtual' => 'nullable|boolean',

            'amount_out' => 'nullable|numeric',

            'payment_account_out.id' => 'nullable|int',
            'payment_account_out.name' => 'nullable|string',
            'payment_account_out.type' => 'nullable|in:standard,bank',
            'payment_account_out.iban' => 'nullable|string',
            'payment_account_out.sia' => 'nullable|string',
            'payment_account_out.cuc' => 'nullable|string',
            'payment_account_out.virtual' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $response = $this->get(
            'c/' . $this->company_id . '/cashbook',
            $data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $cashbookEntries = $response->data;
        return response()->json(['data' => $cashbookEntries], 201);
    }

    public function createCashBookEntry(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'date' => 'required|date',
            'description' => 'required|string',
            'kind' => 'required|in:cashbook,issued_document,received_document,tax,receipt',
            'type' => 'required|in:in,out',
            'entity_name' => 'nullable|string',

            'document.id' => 'nullable|int',
            'document.type' => 'nullable|string',
            'document.path' => 'nullable|string',

            'amount_in' => 'nullable|numeric',

            'payment_account_in.id' => 'nullable|int',
            'payment_account_in.name' => 'nullable|string',
            'payment_account_in.type' => 'nullable|in:standard,bank',
            'payment_account_in.iban' => 'nullable|string',
            'payment_account_in.sia' => 'nullable|string',
            'payment_account_in.cuc' => 'nullable|string',
            'payment_account_in.virtual' => 'nullable|boolean',

            'amount_out' => 'nullable|numeric',

            'payment_account_out.id' => 'nullable|int',
            'payment_account_out.name' => 'nullable|string',
            'payment_account_out.type' => 'nullable|in:standard,bank',
            'payment_account_out.iban' => 'nullable|string',
            'payment_account_out.sia' => 'nullable|string',
            'payment_account_out.cuc' => 'nullable|string',
            'payment_account_out.virtual' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $response = $this->post(
            'c/' . $this->company_id . '/cashbook',
            $data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $cashBookEntry = new CashbookEntries($response->data->data);

        return new CashbookEntries($cashBookEntry);
        //return response()->json(['message' => 'Voce del cashbook creata con successo', 'data' => $cashBookEntry], 201);
    }

    public function all(
        ?array $additional_data = []
    ) {
        $all_entries = $this->getAll([
            'id', 'date', 'description', 'kind', 'type', 'entity_name',
            'document.id', 'document.type', 'document.path',
            'amount_in',
            'payment_account_in.id', 'payment_account_in.name', 'payment_account_in.type', 'payment_account_in.iban', 'payment_account_in.sia', 'payment_account_in.cuc', 'payment_account_in.virtual',
            'amount_out',
            'payment_account_out.id', 'payment_account_out.name', 'payment_account_out.type', 'payment_account_out.iban', 'payment_account_out.sia', 'payment_account_out.cuc', 'payment_account_out.virtual',
        ], 'c/'.$this->company_id.'/CashBook', $additional_data);

        return gettype($all_entries) !== 'array'
            ? $all_entries
            : array_map(function ($entry) {
                return new CashbookEntries($entry);
            }, $all_entries);
    }

    public function detail(
        int $entry_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            'c/'.$this->company_id.'/CashBook/'.$entry_id,
            $additional_data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $cashbook_entry = $response->data->data;

        return new CashbookEntries($cashbook_entry);
    }


    public function updateCashBookEntry(Request $request, $entry_id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'required|string',
            'date' => 'required|date',
            'description' => 'required|string',
            'kind' => 'required|in:cashbook,issued_document,received_document,tax,receipt',
            'type' => 'required|in:in,out',
            'entity_name' => 'string',

            'document.id' => 'int',
            'document.type' => 'string',
            'document.path' => 'string',

            'amount_in' => 'double',

            'payment_account_in.id' => 'nullable|int',
            'payment_account_in.name' => 'required|string',
            'payment_account_in.type' => 'nullable|in:standard,bank',
            'payment_account_in.iban' => 'nullable|string',
            'payment_account_in.sia' => 'nullable|string',
            'payment_account_in.cuc' => 'nullable|string',
            'payment_account_in.virtual' => 'nullable|boolean',

            'amount_out' => 'nullable|double',

            'payment_account_out.id' => 'nullable|int',
            'payment_account_out.name' => 'required|string',
            'payment_account_out.type' => 'nullable|in:standard,bank',
            'payment_account_out.iban' => 'nullable|string',
            'payment_account_out.sia' => 'nullable|string',
            'payment_account_out.cuc' => 'nullable|string',
            'payment_account_out.virtual' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            'c/' . $this->company_id . '/cashbook/' . $entry_id,
            $data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $cashbook_entry = $response->data->data;

        return new CashbookEntries($cashbook_entry);
    }

    public function delete(
        int $entry_id
    )
    {
        $response = $this->destroy(
            'c/' . $this->company_id . '/cashbook/' . $entry_id
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        return 'Cashbook entry deleted';
    }
}
