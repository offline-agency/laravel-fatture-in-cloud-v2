<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentMethod as PaymentMethodEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\PaymentMethodList;

class PaymentMethod extends Api
{
    public function list(): PaymentMethodList|Error
    {
        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/settings/payment_methods',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $paymentMethods = $response->data;

        return new PaymentMethodList($paymentMethods);
    }

    public function detail(int $paymentMethodId): PaymentMethodEntity|Error
    {
        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/settings/payment_methods/'.$paymentMethodId,
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $paymentMethod = $response->data->data;

        return new PaymentMethodEntity($paymentMethod);
    }

    public function delete(int $paymentMethodId): string|Error
    {
        /** @var object $response */
        $response = $this->destroy(
            'c/'.$this->companyId.'/settings/payment_methods/'.$paymentMethodId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Payment method deleted';
    }

    public function create(array $body = []): PaymentMethodEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->post(
            'c/'.$this->companyId.'/settings/payment_methods',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $paymentMethod = $response->data->data;

        return new PaymentMethodEntity($paymentMethod);
    }

    public function edit(int $paymentMethodId, array $body = []): PaymentMethodEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->put(
            'c/'.$this->companyId.'/settings/payment_methods/'.$paymentMethodId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $paymentMethodResponse = $response->data->data;

        return new PaymentMethodEntity($paymentMethodResponse);
    }
}
