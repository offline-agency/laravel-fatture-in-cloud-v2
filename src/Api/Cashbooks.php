<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use OfflineAgency\LaravelFattureInCloudV2\Entities\CashBook\ListCashbookEntries;

class Cashbooks extends Api
{
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

            'amount_in' => 'nullable|double',

            'payment_account_in.id' => 'nullable|int',
            'payment_account_in.name' => 'nullable|string',
            'payment_account_in.type' => 'nullable|in:standard,bank',
            'payment_account_in.iban' => 'nullable|string',
            'payment_account_in.sia' => 'nullable|string',
            'payment_account_in.cuc' => 'nullable|string',
            'payment_account_in.virtual' => 'nullable|boolean',

            'amount_out' => 'nullable|double',

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

        $cashbookEntries = ListCashbookEntries::where($request->all())->get();

        return response()->json(['data' => $cashbookEntries], 200);
    }

    public function createCashBookEntry(Request $request)
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
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $cashbookEntry = new ListCashbookEntries();
            $cashbookEntry->fill($data);
            $cashbookEntry->save();

            return response()->json(['message' => 'Voce del cashbook creata con successo', 'cashbook_entry_id' => $cashbookEntry->id], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Impossibile creare la voce del cashbook'], 500);
        }
    }

    public function getCashBookEntry($id)
    {
        try {
            $cashbookEntry = ListCashbookEntries::find($id);

            if (!$cashbookEntry) {
                return response()->json(['error' => 'Voce del cashbook non trovata'], 404);
            }

            return response()->json(['cashbook_entry' => $cashbookEntry], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Impossibile recuperare la voce del cashbook'], 500);
        }
    }

    public function updateCashBookEntry(Request $request, $id)
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
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $cashbookEntry = ListCashbookEntries::find($id);

            if (!$cashbookEntry) {
                return response()->json(['error' => 'Voce del cashbook non trovata'], 404);
            }

            $cashbookEntry->fill($data);
            $cashbookEntry->save();

            return response()->json(['message' => 'Voce del cashbook aggiornata con successo'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Impossibile aggiornare la voce del cashbook'], 500);
        }
    }

    public function deleteCashBookEntry($id)
    {
        try {
            $cashbookEntry = ListCashbookEntries::find($id);

            if (!$cashbookEntry) {
                return response()->json(['error' => 'Voce del cashbook non trovata'], 404);
            }

            $cashbookEntry->delete();

            return response()->json(['message' => 'Voce del cashbook eliminata con successo'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Impossibile eliminare la voce del cashbook '], 500);
        }
    }

}
