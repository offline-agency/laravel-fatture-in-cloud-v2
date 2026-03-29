<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\Supplier as SupplierEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\SupplierList;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class Supplier extends Api
{
    use ListTrait;

    /**
     * @param  array<string, mixed>  $additionalData
     */
    public function list(array $additionalData = []): SupplierList|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ]);

        $response = $this->get(
            'c/'.$this->companyId.'/entities/suppliers',
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $suppliers = $response->data;

        return new SupplierList($suppliers);
    }

    /**
     * @param  array<string, mixed>  $additionalData
     * @return array<SupplierEntity>|Error
     */
    public function all(array $additionalData = []): array|Error
    {
        $allSuppliers = $this->getAll([
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ], 'c/'.$this->companyId.'/entities/suppliers', $additionalData);

        if ($allSuppliers instanceof Error) {
            return $allSuppliers;
        }

        return array_map(function ($supplier) {
            return new SupplierEntity($supplier);
        }, $allSuppliers);
    }

    /**
     * @param  array<string, mixed>  $additionalData
     */
    public function detail(int $supplierId, array $additionalData = []): SupplierEntity|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
        ]);

        $response = $this->get(
            'c/'.$this->companyId.'/entities/suppliers/'.$supplierId,
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $supplier = $response->data->data;

        return new SupplierEntity($supplier);
    }

    public function delete(int $supplierId): string|Error
    {
        $response = $this->destroy(
            'c/'.$this->companyId.'/entities/suppliers/'.$supplierId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Supplier deleted';
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function create(array $body = []): SupplierEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            'c/'.$this->companyId.'/entities/suppliers',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $supplier = $response->data->data;

        return new SupplierEntity($supplier);
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function edit(int $supplierId, array $body = []): SupplierEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            'c/'.$this->companyId.'/entities/suppliers/'.$supplierId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $supplier = $response->data->data;

        return new SupplierEntity($supplier);
    }
}
