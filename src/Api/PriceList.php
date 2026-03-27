<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\PriceList\PriceList as PriceListEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\PriceList\PriceListList;

class PriceList extends Api
{
    public function list(): PriceListList|Error
    {
        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/settings/pricelists',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $priceLists = $response->data;

        return new PriceListList($priceLists);
    }

    public function detail(int $priceListId): PriceListEntity|Error
    {
        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/settings/pricelists/'.$priceListId,
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $priceList = $response->data->data;

        return new PriceListEntity($priceList);
    }

    public function delete(int $priceListId): string|Error
    {
        /** @var object $response */
        $response = $this->destroy(
            'c/'.$this->companyId.'/settings/pricelists/'.$priceListId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Price list deleted';
    }

    public function create(array $body = []): PriceListEntity|Error|MessageBag
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
            'c/'.$this->companyId.'/settings/pricelists',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $priceList = $response->data->data;

        return new PriceListEntity($priceList);
    }

    public function edit(int $priceListId, array $body = []): PriceListEntity|Error|MessageBag
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
            'c/'.$this->companyId.'/settings/pricelists/'.$priceListId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $priceListResponse = $response->data->data;

        return new PriceListEntity($priceListResponse);
    }
}
