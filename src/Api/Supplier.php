<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Client\Client as ClientEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\Supplier as SupplierEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Supplier\SupplierList;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class Supplier extends Api
{
    use ListTrait;

    private $all;

    public function list(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ]);

        $response = $this->get(
            $this->company_id.'/entities/suppliers',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $suppliers = $response->data;

        return new SupplierList($suppliers);
    }

    public function all(
        ?array $additional_data = []
    )
    {
        $all_suppliers = $this->getAll([
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ], $this->company_id.'/entities/suppliers', $additional_data);

        return gettype($all_suppliers) !== 'array'
            ? $all_suppliers
            : array_map(function ($supplier) {
                return new SupplierEntity($supplier);
            }, $all_suppliers);
    }

    public function detail(
        int $supplier_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            $this->company_id.'/entities/suppliers/'.$supplier_id,
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $supplier = $response->data->data;

        return new SupplierEntity($supplier);
    }

    public function delete(
        int $supplier_id
    ) {
        $response = $this->destroy(
            $this->company_id.'/entities/suppliers/'.$supplier_id
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Supplier deleted';
    }

    public function create(
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            $this->company_id.'/entities/suppliers',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $supplier = $response->data->data;

        return new SupplierEntity($supplier);
    }

    public function edit(
        int $supplier_id,
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            $this->company_id.'/entities/suppliers/'.$supplier_id,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $supplier_id = $response->data->data;

        return new SupplierEntity($supplier_id);
    }
}
