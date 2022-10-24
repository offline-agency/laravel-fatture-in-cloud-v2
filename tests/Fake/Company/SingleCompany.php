<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Company;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SingleCompany extends FakeResponse
{
    public function getCompanyFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'name' => $this->value($params, 'name', 'fake_name'),
            'email' => $this->value($params, 'email', 'fake_email'),
            'type' => $this->value($params, 'type', 'fake_type'),
            'fic' => $this->value($params, 'fic', true),
            'fic_plan_name' => $this->value($params, 'fic_plan_name', 'fake_fic_plan_name'),
            'fic_signup_date' => $this->value($params, 'fic_signup_date', 'fake_fic_signup_date'),
            'fic_license_expire' => $this->value($params, 'fic_license_expire', 'fake_fic_license_expire'),
            'use_fic' => $this->value($params, 'use_fic', true),
            'fic_need_setup' => $this->value($params, 'fic_need_setup', false),
            'fic_license_type' => $this->value($params, 'fic_license_type', 'fake_fic_license_type'),
            'dic' => $this->value($params, 'dic', true),
            'dic_plan_name' => $this->value($params, 'dic_plan_name', 'fake_dic_plan_name'),
            'dic_signup_date' => $this->value($params, 'dic_signup_date', 'fake_dic_signup_date'),
            'dic_license_expire' => $this->value($params, 'dic_license_expire', 'fake_dic_license_expire'),
            'use_dic' => $this->value($params, 'use_dic', true),
            'dic_license_type' => $this->value($params, 'dic_license_type', 'fake_dic_license_type'),
            'registration_service' => $this->value($params, 'registration_service', 'fake_registration_service'),
            'can_use_coupon' => $this->value($params, 'can_use_coupon', false),
            'access_info' => $this->value($params, 'access_info', [
                'role' => $this->value($params, 'role', 'fake_role'),
                'through_accountant' => $this->value($params, 'through_accountant', false),
                'permissions' => $this->value($params, 'permissions', [
                    'fic_situation' => $this->value($params, 'fic_situation', 'fake_fic_situation'),
                    'fic_clients' => $this->value($params, 'fic_clients', 'fake_fic_clients'),
                    'fic_suppliers' => $this->value($params, 'fic_suppliers', 'fake_fic_suppliers'),
                    'fic_products' => $this->value($params, 'fic_products', 'fake_fic_products'),
                    'fic_issued_documents' => $this->value($params, 'fic_issued_documents', 'fake_fic_issued_documents'),
                    'fic_issued_documents_detailed' => $this->value($params, 'fic_issued_documents_detailed', [
                        'quotes' => $this->value($params, 'quotes', 'fake_quotes'),
                        'proformas' => $this->value($params, 'proformas', 'fake_proformas'),
                        'invoices' => $this->value($params, 'invoices', 'fake_invoices'),
                        'receipts' => $this->value($params, 'receipts', 'fake_receipts'),
                        'delivery_notes' => $this->value($params, 'delivery_notes', 'fake_delivery_notes'),
                        'credit_notes' => $this->value($params, 'credit_notes', 'fake_credit_notes'),
                        'orders' => $this->value($params, 'orders', 'fake_orders'),
                        'work_reports' => $this->value($params, 'work_reports', 'fake_work_reports'),
                        'supplier_orders' => $this->value($params, 'supplier_orders', 'fake_supplier_orders'),
                        'self_invoices' => $this->value($params, 'self_invoices', 'fake_self_invoices'),
                    ]),
                    'fic_received_documents' => $this->value($params, 'fic_received_documents', 'fake_fic_received_documents'),
                    'fic_receipts' => $this->value($params, 'fic_receipts', 'fake_fic_receipts'),
                    'fic_calendar' => $this->value($params, 'fic_calendar', 'fake_fic_calendar'),
                    'fic_archive' => $this->value($params, 'fic_archive', 'fake_fic_archive'),
                    'fic_taxes' => $this->value($params, 'fic_taxes', 'fake_fic_taxes'),
                    'fic_stock' => $this->value($params, 'fic_stock', 'fake_fic_stock'),
                    'fic_cashbook' => $this->value($params, 'fic_cashbook', 'fake_fic_cashbook'),
                    'fic_settings' => $this->value($params, 'fic_settings', 'fake_fic_settings'),
                    'fic_emails' => $this->value($params, 'fic_emails', 'fake_fic_emails'),
                    'dic_employees' => $this->value($params, 'dic_employees', 'fake_dic_employees'),
                    'dic_timesheet' => $this->value($params, 'dic_timesheet', 'fake_dic_timesheet'),
                    'dic_settings' => $this->value($params, 'dic_settings', 'fake_dic_settings'),
                    'fic_invoice_trading' => $this->value($params, 'fic_invoice_trading', 'fake_fic_invoice_trading'),
                    'fic_export' => $this->value($params, 'fic_export', 'fake_fic_export'),
                    'fic_import_clients_suppliers' => $this->value($params, 'fic_import_clients_suppliers', 'fake_fic_import_clients_suppliers'),
                    'fic_import_products' => $this->value($params, 'fic_import_products', 'fake_fic_import_products'),
                    'fic_import_issued_documents' => $this->value($params, 'fic_import_issued_documents', 'fake_fic_import_issued_documents'),
                    'fic_import_bankstatements' => $this->value($params, 'fic_import_bankstatements', 'fake_fic_import_bankstatements'),
                    'fic_recurring' => $this->value($params, 'fic_recurring', 'fake_fic_recurring'),
                    'fic_riba' => $this->value($params, 'fic_riba', 'fake_fic_riba'),
                ]),
            ]),
        ];
    }
}
