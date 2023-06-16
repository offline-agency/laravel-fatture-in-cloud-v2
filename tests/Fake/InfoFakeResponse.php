<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info\SinglePaymentMethods;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info\SinglePaymentAccounts;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info\SingleArchiveCategories;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info\SingleCostCenters;


use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info\SingleProductsCategories;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info\SingleReceivedDocumentCategories;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info\SingleRevenueCenters;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info\SingleVat;

class InfoFakeResponse extends FakeResponse
{
    public function getVatTypesFakeList(
        array $params = []
    ) {
        return json_encode([
            'data' => [
                (new SingleVat())->getVatTypeFakeDetail($params),
                (new SingleVat())->getVatTypeFakeDetail($params),
            ],
        ]
        );
    }

    public function getEmptyVatTypesFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ]
        ));
    }

    public function getVatTypesFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }

    //Payment Methods
    public function getPaymentMethodsTypeFakeList(
        array $params = []
    ) {
        return json_encode([
                'data' => [
                    (new SinglePaymentMethods())->getPaymentMethodsTypeFakeDetail($params),
                    (new SinglePaymentMethods())->getPaymentMethodsTypeFakeDetail($params),
                ],
            ]
        );
    }

    public function getEmptyPaymentMethodsTypesFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ]
        ));
    }

    public function getPaymentMethodsTypesFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }

    //Payment Accounts
    public function getPaymentAccountsTypeFakeList(
        array $params = []
    ) {
        return json_encode([
                'data' => [
                    (new SinglePaymentAccounts())->getPaymentAccountsTypeFakeDetail($params),
                    (new SinglePaymentAccounts())->getPaymentAccountsTypeFakeDetail($params),
                ],
            ]
        );
    }

    public function getEmptyPaymentAccountsTypesFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ]
        ));
    }

    public function getPaymentAccountsTypesFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }

    //Revenue Centers

    public function getRevenueCentresTypeFakeList(
        array $params = []
    ) {
        return json_encode([
                'data' => [
                    (new SingleRevenueCenters())->getRevenueCentersTypeFakeDetail($params),
                    (new SingleRevenueCenters())->getRevenueCentersTypeFakeDetail($params),
                ],
            ]
        );
    }

    public function getEmptyRevenueCentersTypesFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ]
        ));
    }

    public function getRevenueCentersTypesFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }

    //Cost Centers

    public function getCostCentersTypeFakeList(
        array $params = []
    ) {
        return json_encode([
                'data' => [
                    (new SingleCostCenters())->getCostCentersTypeFakeDetail($params),
                    (new SingleCostCenters())->getCostCentersTypeFakeDetail($params),
                ],
            ]
        );
    }

    public function getEmptyCostCentersTypesFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ]
        ));
    }

    public function getCostCentersTypesFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }

    //Products Categories
    public function getProductsCategoriesTypeFakeList(
        array $params = []
    ) {
        return json_encode([
                'data' => [
                    (new SingleProductsCategories())->getProductsCategoriesTypeFakeDetail($params),
                    (new SingleProductsCategories())->getProductsCategoriesTypeFakeDetail($params),
                ],
            ]
        );
    }

  public function getEmptyProductsCategoriesTypesFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ]
        ));
    }

    public function getProductsCategoriesTypesFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }

    //Received Document Categories
    public function getReceivedDocumentCategoriesTypeFakeList(
        array $params = []
    ) {
        return json_encode([
                'data' => [
                    (new SingleReceivedDocumentCategories())->getReceivedDocumentCategoriesTypeFakeDetail($params),
                    (new SingleReceivedDocumentCategories())->getReceivedDocumentCategoriesTypeFakeDetail($params),
                ],
            ]
        );
    }

    public function getEmptyReceivedDocumentCategoriesTypesFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ]
        ));
    }

    public function getReceivedDocumentCategoriesTypesFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }

    //Archive Categories
    public function getArchiveCategoriesTypeFakeList(
        array $params = []
    ) {
        return json_encode([
                'data' => [
                    (new SingleArchiveCategories())->getArchiveCategoriesTypeFakeDetail($params),
                    (new SingleArchiveCategories())->getArchiveCategoriesTypeFakeDetail($params),
                ],
            ]
        );
    }

    public function getEmptyArchiveCategoriesTypesFakeList(
        array $params = []
    ) {
        return json_encode(array_merge(
            [
                'data' => [],
            ]
        ));
    }

    public function getArchiveCategoriesTypesFakeError(
        array $params = []
    ) {
        return json_encode((new ErrorFakeResponse())->getErrorFake($params));
    }


}
