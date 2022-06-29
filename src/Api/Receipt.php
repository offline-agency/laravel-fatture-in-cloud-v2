<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\Receipt as ReceiptEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Receipt\ReceiptList;

class Receipt extends Api
{
    public function list(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset', 'sort', 'page', 'per_page', 'q',
        ]);

        $response = $this->get(
            $this->company_id.'/products',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $products = $response->data;

        return new ReceiptList($products);
    }

    public function detail(
        int $product_id,
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields', 'fieldset',
        ]);

        $response = $this->get(
            '/c/'.$company_id.'/receipts',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $products = $response->data->data;

        return new ReceiptEntity($products);
    }

    public function delete(
        int $product_id
    ) {
        $response = $this->destroy(
            '/c/'.$company_id.'/receipts'
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Product deleted';
    }

    public function create(
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required_without_all:data.code,data.description',
            'data.code' => 'required_without_all:data.name,data.description',
            'data.description' => 'required_without_all:data.name,data.code',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post(
            '/c/'.$company_id.'/receipts',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $product = $response->data->data;

        return new ReceiptEntity($product);
    }

    public function edit(
        int $product_id,
        array $body = []
    ) {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.name' => 'required_without_all:data.code,data.description',
            'data.code' => 'required_without_all:data.name,data.description',
            'data.description' => 'required_without_all:data.name,data.code',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put(
            '/c/'.$company_id.'/receipts',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $product = $response->data->data;

        return new ReceiptEntity($product);
    }
}
