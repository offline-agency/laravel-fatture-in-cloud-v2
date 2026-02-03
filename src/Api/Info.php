<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoArchiveCategoriesList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoPaymentAccountsList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoPaymentMethodsList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoReceivedDocumentCategoriesList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoRevenueCentersList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoCostCentersList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Info\InfoProductsCategoriesList;

class Info extends Api
{
    public function listVatTypes(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fieldset',
        ]);

        $response = $this->get(
            $this->company_id.'/info/vat_types',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $vats = $response->data;

        return new InfoList($vats);
    }

    //Payment Methods
    public function listPaymentMethods(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields',
            'fieldset',
            'sort',
        ]);

        $response = $this->get(
            $this->company_id.'/info/payment_methods',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $methods = $response->data;

        return new InfoPaymentMethodsList($methods);
    }

    //Payment Accounts
    public function listPaymentAccounts(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'fields',
            'fieldset',
            'sort',
        ]);

        $response = $this->get(
            $this->company_id.'/info/payment_accounts',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $accounts = $response->data;

        return new InfoPaymentAccountsList($accounts);
    }

    //Revenue Centers
    public function listRevenueCenters(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [

        ]);

        $response = $this->get(
            $this->company_id.'/info/revenue_centers',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $accounts = $response->data;

        return new InfoRevenueCentersList($accounts);
    }

    //Cost Centers
    public function listCostCenters(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
        ]);

        $response = $this->get(
            $this->company_id.'/info/cost_centers',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $accounts = $response->data;

        return new InfoCostCentersList($accounts);
    }

    //Products Categories
    public function listProductsCategories(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [
            'context',
        ]);

        $response = $this->get(
            $this->company_id.'/info/product_categories',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $accounts = $response->data;

        return new InfoProductsCategoriesList($accounts);
    }

    public function listReceivedDocumentCategories(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [

        ]);

        $response = $this->get(
            $this->company_id.'/info/received_document_categories',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $accounts = $response->data;

        return new InfoReceivedDocumentCategoriesList($accounts);
    }

    public function listArchiveCategories(
        ?array $additional_data = []
    ) {
        $additional_data = $this->data($additional_data, [

        ]);

        $response = $this->get(
            $this->company_id.'/info/archive_categories',
            $additional_data
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $accounts = $response->data;

        return new InfoArchiveCategoriesList($accounts);
    }

}
