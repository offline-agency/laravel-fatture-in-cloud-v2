<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\User;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SingleCompany extends FakeResponse
{
    public function getCompanyFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'name' => $this->value($params, 'name', 'fake_name'),
            'alias' => $this->value($params, 'alias', 'fake_name'),
            'vat_number' => $this->value($params, 'vat_number', 'fake_name'),
            'tax_code' => $this->value($params, 'tax_code', 'fake_tax_code'),
            'type' => $this->value($params, 'type', 'fake_type'),
            'connection_id' => $this->value($params, 'connection_id', 'fake_connection_id'),
            'controlled_companies' => $this->value($params, 'controlled_companies', 1),
            'fic' => $this->value($params, 'fic', true),
            'dic' => $this->value($params, 'dic', true),
            'fic_plan' => $this->value($params, 'fic_plan', 'fake_fic_plan'),
            'fic_license_expire' => $this->value($params, 'fic_license_expire', 'fake_fic_license_expire'),
            'permissions' => $this->value($params, 'permissions', [
                'fic_situation' => $this->value($params, 'permissions.fic_situation','fake_fic_situation'),
                'fic_clients' => $this->value($params, 'permissions.fic_clients','fake_fic_clients'),
                'fic_suppliers' => $this->value($params, 'permissions.fic_suppliers','fake_fic_suppliers'),
                'fic_products' => $this->value($params, 'permissions.fic_products','fake_fic_products'),
                'fic_issued_documents' => $this->value($params, 'permissions.fic_issued_documents','fake_fic_issued_documents'),
                'fic_received_documents' => $this->value($params, 'permissions.fic_received_documents','fake_fic_received_documents'),
                'fic_receipts' => $this->value($params, 'permissions.fic_receipts','fake_fic_receipts'),
                'fic_calendar' => $this->value($params, 'permissions.fic_calendar','fake_fic_calendar'),
                'fic_archive' => $this->value($params, 'permissions.fic_archive','fake_fic_archive'),
                'fic_taxes' => $this->value($params, 'permissions.fic_taxes','fake_fic_taxes'),
                'fic_stock' => $this->value($params, 'permissions.fic_stock','fake_fic_stock'),
                'fic_cashbook' => $this->value($params, 'permissions.fic_cashbook','fake_fic_cashbook'),
                'fic_settings' => $this->value($params, 'permissions.fic_settings','fake_fic_settings'),
                'fic_emails' => $this->value($params, 'permissions.fic_emails','fake_fic_emails'),
                'dic_employees' => $this->value($params, 'permissions.dic_employees','fake_dic_employees'),
                'dic_timesheet' => $this->value($params, 'permissions.dic_timesheet','fake_dic_timesheet'),
                'dic_settings' => $this->value($params, 'permissions.dic_settings','fake_dic_settings')
            ]),
        ];
    }
}
