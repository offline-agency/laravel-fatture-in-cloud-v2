<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\IssuedDocument;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class PreCreateInfo extends FakeResponse
{
    public function getPreCreateInfoFake(
        array $params = []
    ): array {
        return [
            'numerations' => $this->value($params, 'numerations', [
                '2022' => [
                    '' => 5,
                ],
            ]),
            'dn_numerations' => $this->value($params, 'dn_numerations', (object) []),
            'default_values' => $this->value($params, 'default_values', [
                'notes' => '',
            ]),
            'extra_data_default_values' => $this->value($params, 'extra_data_default_values', [
                'ts_communication' => false,
            ]),
            'items_default_values' => $this->value($params, 'items_default_values', [
                'vat' => [
                    'id' => 0,
                    'value' => 22,
                ],
            ]),
            'countries_list' => $this->value($params, 'countries_list', [
                'Italia',
                'Afghanistan',
            ]),
            'currencies_list' => $this->value($params, 'currencies_list', [
                [
                    'id' => 'AED',
                    'symbol' => 'AED',
                    'html_symbol' => 'AED',
                    'exchange_rate' => '3.82580',
                ], [
                    'id' => 'EUR',
                    'symbol' => '€',
                    'html_symbol' => '&euro;',
                    'exchange_rate' => '1.00000',
                ],
            ]),
            'templates_list' => $this->value($params, 'templates_list', [
                [
                    'id' => 10,
                    'name' => 'New Standard S1',
                    'supports_custom_taxable' => true,
                ], [
                    'id' => 11,
                    'name' => 'New Standard S2',
                    'supports_custom_taxable' => true,
                ],
            ]),
            'dn_templates_list' => $this->value($params, 'dn_templates_list', [
                [
                    'id' => 660,
                    'name' => 'DDT 1',
                    'supports_custom_taxable' => false,
                ], [
                    'id' => 3053,
                    'name' => 'Light Smoke - DDT (senza prezzi)',
                    'supports_custom_taxable' => false,
                ],
            ]),
            'ai_templates_list' => $this->value($params, 'ai_templates_list', [
                [
                    'id' => 663,
                    'name' => 'FT Accompagnatoria 1',
                    'supports_custom_taxable' => false,
                ], [
                    'id' => 3054,
                    'name' => 'Light Smoke - FT ACC',
                    'supports_custom_taxable' => true,
                ],
            ]),
            'payment_methods_list' => $this->value($params, 'payment_methods_list', [
                [
                    'id' => 1,
                    'name' => 'Bonifico',
                ], [
                    'id' => 2,
                    'name' => 'Assegno',
                ],
            ]),
            'payment_accounts_list' => $this->value($params, 'payment_accounts_list', [
                [
                    'id' => 1,
                    'name' => 'Braintree',
                ], [
                    'id' => 2,
                    'name' => 'PAYPAL',
                ],
            ]),
            'vat_types_list' => $this->value($params, 'vat_types_list', [
                [
                    'id' => 0,
                    'value' => 22,
                    'description' => '',
                    'ei_type' => '0',
                    'is_disabled' => false,
                ], [
                    'id' => 1,
                    'value' => 21,
                    'description' => '',
                    'ei_type' => '0',
                    'is_disabled' => false,
                ],
            ]),
            'measures_list' => $this->value($params, 'measures_list', [
                'pezzi',
                'kg',
            ]),
            'languages_list' => $this->value($params, 'languages_list', [
                [
                    'code' => 'it',
                    'name' => 'Italiano',
                ], [
                    'code' => 'en',
                    'name' => 'Inglese',
                ],
            ]),
            'ei_structure' => $this->value($params, 'ei_structure', [
                'FatturaElettronicaHeader' => [
                    'idx' => 1,
                ],
            ]),
        ];
    }
}
