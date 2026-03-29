<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\VatType as VatTypeEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Settings\VatTypeList;

class VatType extends Api
{
    public function list(): VatTypeList|Error
    {
        $response = $this->get(
            'c/'.$this->companyId.'/settings/vat_types',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $vatTypes = $response->data;

        return new VatTypeList($vatTypes);
    }

    public function detail(int $vatTypeId): VatTypeEntity|Error
    {
        $response = $this->get(
            'c/'.$this->companyId.'/settings/vat_types/'.$vatTypeId,
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $vatType = $response->data->data;

        return new VatTypeEntity($vatType);
    }

    public function delete(int $vatTypeId): string|Error
    {
        $response = $this->destroy(
            'c/'.$this->companyId.'/settings/vat_types/'.$vatTypeId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'VAT type deleted';
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function create(array $body = []): VatTypeEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.value' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->companyId.'/settings/vat_types',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $vatType = $response->data->data;

        return new VatTypeEntity($vatType);
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function edit(int $vatTypeId, array $body = []): VatTypeEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.value' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            'c/'.$this->companyId.'/settings/vat_types/'.$vatTypeId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $vatTypeResponse = $response->data->data;

        return new VatTypeEntity($vatTypeResponse);
    }
}
