<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;


use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\Vat;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentMethods;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentAccount;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\VatType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\ErrorFakeResponse;


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

        $response = $this->post(
            'c/'.$this->company_id.'/Settings/payment_methods',
            $data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $paymentMethod = new PaymentMethods();

        return new PaymentMethods($paymentMethod);
    }

    public function getPaymentMethod($payment_method_id)
    {
            $response = $this->get(
                'c/'.$this->company_id.'/Settings/payment_methods/'.$payment_method_id
            );

            if (!$response->success){
                return new Error($response->data);
            }

            $paymentMethod = $response->data;

            return response()->json(['payment_method' => $paymentMethod], 201);
    }

    public function updatePaymentMethod(Request $request, $payment_method_id)
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

        $response = $this->put(
            'c/'.$this->company_id.'/Settings/payment_methods/'.$payment_method_id,
            $data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $payment_method = $response->data->data;

        return new PaymentMethods($payment_method);
    }

    public function deletePaymentMethod($payment_method_id)
    {
        $response = $this->destroy(
            'c/'.$this->company_id.'/Settings/payment_methods/'.$payment_method_id
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return response()->json(['message' => 'Metodo di pagamento eliminato con successo'], 201);
    }



    // PaymentAccount


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

        $response = $this->post(
            'c/'.$this->company_id.'/Settings/payment_accounts',
            $data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $paymentAccount = new PaymentAccount();

        return new PaymentAccount($paymentAccount);
    }

    public function getPaymentAccount($payment_account_id)
    {
        $response = $this->get(
            'c/'.$this->company_id.'/Settings/payment_accounts/'.$payment_account_id
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $paymentAccount = $response->data;

        return response()->json(['payment_account' => $paymentAccount], 201);
    }

    public function updatePaymentAccount(Request $request, $payment_account_id)
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

        $response = $this->put(
            'c/'.$this->company_id.'/Settings/payment_accounts/'.$payment_account_id,
            $data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $payment_account = $response->data;

        return new PaymentAccount($payment_account);
    }

    public function deletePaymentAccount($payment_account_id)
    {
        $response = $this->destroy(
            'c/'.$this->company_id.'/Settings/payment_accounts/'.$payment_account_id
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        return response()->json(['message' => 'Account di pagamento eliminato con successo'], 201);
    }





    // VatType

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

        $response = $this->post(
            'c/'.$this->company_id.'/Settings/vat_types',
            $data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $vatType = new VatType();
        return new VatType($vatType);
        //return response()->json(['message' => 'Tipo di IVA creato con successo', 'vat_type_id' => $vatType->id], 201);
    }

    public function getVatType($vat_type_id)
    {
        $response = $this->get(
            'c/'.$this->company_id.'/Settings/vat_types/'.$vat_type_id
        );

        if (!$response->success) {
            return new Error($response->data);
            //return response()->json(['error' => 'Tipo di IVA non trovato'], 400);
        }

        $vatType = $response->data;

        return response()->json(['data' => $vatType], 201);
    }

    public function updateVatType(Request $request, $vat_type_id)
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

        $response = $this->put(
            'c/'.$this->company_id.'/Settings/vat_types/'.$vat_type_id,
            $data
        );

        if (!$response->success) {
            return new Error($response->data);
        }

        $vat_type = $response->data;

        return new VatType($vat_type);
        //return response()->json(['message' => 'Tipo di IVA aggiornato con successo', 'data' => $vatType], 201);
    }

    public function deleteVatType($vat_type_id)
    {
        $response = $this->destroy(
            'c/'.$this->company_id.'/Settings/vat_types'.$vat_type_id
        );

        if (!$response->success) {
            return new Error($response->data);
            //return response()->json(['error' => 'Tipo di IVA non trovato'], 404);
        }

        return response()->json(['message' => 'Tipo di IVA eliminato con successo'], 200);
    }
}
