<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use App\Entities\Settings\PaymentMethods;
use App\Entities\Settings\PaymentAccount;
use App\Entities\Settings\VatType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;


class Setting extends Api
{
    public function createPaymentMethod(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'int',
            'name' => 'required|string',
            'type' => 'string',
            'is_default' => 'boolean',
            'default_payment_account.id' => 'int',
            'default_payment_account.name' => 'required|string',
            'default_payment_account.type' => 'string|nullable',
            'default_payment_account.iban' => 'string',
            'default_payment_account.sia' => 'string',
            'default_payment_account.cuc' => 'string',
            'default_payment_account.virtual' => 'boolean',
            'details.*.title' => 'string|nullable',
            'details.*.description' => 'string|nullable',
            'bank_iban' => 'string',
            'bank_name' => 'string',
            'bank_beneficiary' => 'string',
            'ei_payment_method' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $paymentMethod = new PaymentMethods();
        $paymentMethod->fill($data);
        $paymentMethod->save();

        return response()->json(['message' => 'Metodo di pagamento creato con successo', 'payment_method_id' => $paymentMethod->id], 201);
    }

    public function getPaymentMethod($id)
    {
        $paymentMethod = PaymentMethods::find($id);

        if (!$paymentMethod) {
            return Response->json(['error' => 'Metodo di pagamento non trovato'], 404);
        }

        return Response->json(['payment_method' => $paymentMethod], 200);
    }

    public function updatePaymentMethod(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'int',
            'name' => 'required|string',
            'type' => 'string',
            'is_default' => 'boolean',
            'default_payment_account.id' => 'int',
            'default_payment_account.name' => 'required|string',
            'default_payment_account.type' => 'string|nullable',
            'default_payment_account.iban' => 'string',
            'default_payment_account.sia' => 'string',
            'default_payment_account.cuc' => 'string',
            'default_payment_account.virtual' => 'boolean',
            'details.*.title' => 'string|nullable',
            'details.*.description' => 'string|nullable',
            'bank_iban' => 'string',
            'bank_name' => 'string',
            'bank_beneficiary' => 'string',
            'ei_payment_method' => 'string',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $paymentMethod = PaymentMethods::find($id);

        if (!$paymentMethod) {
            return response()->json(['error' => 'Metodo di pagamento non trovato'], 404);
        }

        $paymentMethod->update($data);

        return response()->json(['message' => 'Metodo di pagamento aggiornato con successo', 'payment_method_id' => $id], 200);
    }

    public function deletePaymentMethod($id)
    {
        $paymentMethod = PaymentMethods::find($id);

        if (!$paymentMethod) {
            return response()->json(['error' => 'Metodo di pagamento non trovato'], 404);
        }

        $paymentMethod->delete();

        return response()->json(['message' => 'Metodo di pagamento eliminato con successo'], 200);
    }

    public function createPaymentAccount(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'int',
            'name' => 'required|string',
            'type' => 'string',
            'iban' => 'string',
            'sia' => 'string',
            'cuc' => 'string',
            'virtual' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $paymentAccount = new PaymentAccount();
        $paymentAccount->fill($data);
        $paymentAccount->save();

        return response()->json(['message' => 'Account di pagamento creato con successo', 'payment_account_id' => $paymentAccount->id], 201);
    }

    public function getPaymentAccount($id)
    {
        $paymentAccount = PaymentAccount::find($id);

        if (!$paymentAccount) {
            return response()->json(['error' => 'Account di pagamento non trovato'], 404);
        }

        return response()->json(['payment_account' => $paymentAccount], 200);
    }

    public function updatePaymentAccount(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'int',
            'name' => 'required|string',
            'type' => 'string',
            'iban' => 'string',
            'sia' => 'string',
            'cuc' => 'string',
            'virtual' => 'boolean',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $paymentAccount = PaymentAccount::find($id);

        if(!$paymentAccount) {
            return response()->json(['error' => 'Account di pagamento non trovato'], 404);
        }

        $paymentAccount->update($data);

        return response()->json(['message' => 'Account aggiornato con successo', 'payment_account_id' => $id], 200);
    }

    public function deletePaymentAccount($id)
    {
        $paymentAccount = PaymentAccount::find($id);

        if (!$paymentAccount) {
            return response()->json(['error' => 'Account di pagamento non trovato'], 404);
        }

        $paymentAccount->delete();

        return response()->json(['message' => 'Account di pagamento eliminato con successo'], 200);
    }

    public function createVatType(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'int',
            'value' => 'required|numeric',
            'description' => 'string',
            'notes' => 'string',
            'e_invoice' => 'boolean',
            'ei_type' => 'string',
            'ei_description' => 'string',
            'editable' => 'boolean',
            'is_disabled' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $vatType = new VatType();
        $vatType->fill($data);
        $vatType->save();

        return response()->json(['message' => 'Tipo di IVA creato con successo', 'vat_type_id' => $vatType->id], 201);
    }

    public function getVatType($id)
    {
        $vatType = VatType::find($id);

        if (!$vatType) {
            return response()->json(['error' => 'Tipo di IVA non trovato'], 404);
        }

        $vatType->editable = false;

        return response()->json(['data' => $vatType], 200);
    }

    public function updateVatType(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'value' => 'numeric',
            'description' => 'string',
            'notes' => 'string',
            'e_invoice' => 'boolean',
            'ei_type' => 'string',
            'ei_description' => 'string',
            'is_disabled' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $vatType = VatType::find($id);

        if (!$vatType) {
            return response()->json(['error' => 'Tipo di IVA non trovato'], 404);
        }

        $vatType->fill($data);
        $vatType->save();

        return response()->json(['message' => 'Tipo di IVA aggiornato con successo', 'data' => $vatType], 200);
    }

    public function deleteVatType($id)
    {
        $vatType = VatType::find($id);

        if (!$vatType) {
            return response()->json(['error' => 'Tipo di IVA non trovato'], 404);
        }

        $vatType->delete();

        return response()->json(['message' => 'Tipo di IVA eliminato con successo'], 200);
    }
}
