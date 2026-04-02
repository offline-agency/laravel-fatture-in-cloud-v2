<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Traits\CastsFromMixed;

readonly class IssuedDocumentPreCreateInfo
{
    use CastsFromMixed;

    public mixed $numerations;

    public mixed $dnNumerations;

    public mixed $defaultValues;

    public mixed $extraDataDefaultValues;

    public mixed $itemsDefaultValues;

    public mixed $countriesList;

    public mixed $currenciesList;

    public mixed $templatesList;

    public mixed $dnTemplatesList;

    public mixed $aiTemplatesList;

    public mixed $paymentMethodsList;

    public mixed $paymentAccountsList;

    public mixed $vatTypesList;

    public mixed $measuresList;

    public mixed $languagesList;

    public mixed $eiStructure;

    public function __construct(mixed $parameters = null)
    {
        $parameters = self::normalizeParameters($parameters);

        $this->numerations = self::mixedValue($parameters, 'numerations');
        $this->dnNumerations = self::mixedValue($parameters, 'dn_numerations');
        $this->defaultValues = self::mixedValue($parameters, 'default_values');
        $this->extraDataDefaultValues = self::mixedValue($parameters, 'extra_data_default_values');
        $this->itemsDefaultValues = self::mixedValue($parameters, 'items_default_values');
        $this->countriesList = self::mixedValue($parameters, 'countries_list');
        $this->currenciesList = self::mixedValue($parameters, 'currencies_list');
        $this->templatesList = self::mixedValue($parameters, 'templates_list');
        $this->dnTemplatesList = self::mixedValue($parameters, 'dn_templates_list');
        $this->aiTemplatesList = self::mixedValue($parameters, 'ai_templates_list');
        $this->paymentMethodsList = self::mixedValue($parameters, 'payment_methods_list');
        $this->paymentAccountsList = self::mixedValue($parameters, 'payment_accounts_list');
        $this->vatTypesList = self::mixedValue($parameters, 'vat_types_list');
        $this->measuresList = self::mixedValue($parameters, 'measures_list');
        $this->languagesList = self::mixedValue($parameters, 'languages_list');
        $this->eiStructure = self::mixedValue($parameters, 'ei_structure');
    }
}
