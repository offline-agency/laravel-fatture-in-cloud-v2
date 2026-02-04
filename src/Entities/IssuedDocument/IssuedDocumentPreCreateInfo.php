<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\IssuedDocument;

readonly class IssuedDocumentPreCreateInfo
{
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
        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->numerations = $parameters['numerations'] ?? null;
        $this->dnNumerations = $parameters['dn_numerations'] ?? null;
        $this->defaultValues = $parameters['default_values'] ?? null;
        $this->extraDataDefaultValues = $parameters['extra_data_default_values'] ?? null;
        $this->itemsDefaultValues = $parameters['items_default_values'] ?? null;
        $this->countriesList = $parameters['countries_list'] ?? null;
        $this->currenciesList = $parameters['currencies_list'] ?? null;
        $this->templatesList = $parameters['templates_list'] ?? null;
        $this->dnTemplatesList = $parameters['dn_templates_list'] ?? null;
        $this->aiTemplatesList = $parameters['ai_templates_list'] ?? null;
        $this->paymentMethodsList = $parameters['payment_methods_list'] ?? null;
        $this->paymentAccountsList = $parameters['payment_accounts_list'] ?? null;
        $this->vatTypesList = $parameters['vat_types_list'] ?? null;
        $this->measuresList = $parameters['measures_list'] ?? null;
        $this->languagesList = $parameters['languages_list'] ?? null;
        $this->eiStructure = $parameters['ei_structure'] ?? null;
    }
}
