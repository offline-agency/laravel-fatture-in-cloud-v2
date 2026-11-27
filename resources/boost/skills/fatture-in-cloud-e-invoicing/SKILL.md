---
name: fatture-in-cloud-e-invoicing
description: Create invoices and send them as Italian electronic invoices (fattura elettronica, SDI) with offline-agency/laravel-fatture-in-cloud-v2. Use when issuing invoices, computing totals, verifying e-invoice XML, sending to SDI or tracking e-invoice status in Fatture in Cloud.
---

# E-invoicing with Fatture in Cloud

Use `OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade as FIC`. Every method returns an entity, an `Entities\Error` (API error) or a `MessageBag` (local validation). Check the type at each step and stop on failure.

The flow documented by Fatture in Cloud is: create the invoice with `e_invoice: true`, verify its XML, then send it to SDI, then follow `ei_status`.

## 1. Look up IDs instead of guessing

VAT rates, payment accounts and payment methods are referenced by ID, and IDs differ per company. Never hard-code a VAT id such as `0`; look it up:

```php
$vatTypes = FIC::info()->listVatTypes(); // InfoList of Entities\Info\Vat: ->id, ->value, ->description
$vat22 = collect($vatTypes->getItems())->firstWhere('value', 22.0);
```

## 2. Preview totals, then create the invoice

The sum of `payments_list` must match the document total, or the API answers 422 ("Il totale dei pagamenti non corrisponde al totale da pagare"). Amounts are rounded to 2 decimals before the check. Preview the totals with the same body first; this creates nothing:

```php
$body = [
    'data' => [
        'type' => 'invoice',
        'e_invoice' => true,
        'date' => now(),
        'entity' => [
            'name' => 'Mario Rossi S.r.l.',
            'vat_number' => '47803200154',
            'tax_code' => '47803200154',
            'address_street' => 'Via Italia, 66',
            'address_postal_code' => '20900',
            'address_city' => 'Milano',
            'address_province' => 'MI',
            'country' => 'Italia',
            'ei_code' => '0000000',          // 7-char SDI recipient code; '0000000' when using certified_email
            'certified_email' => 'pec@example.it',
        ],
        'items_list' => [
            ['name' => 'Consulting', 'qty' => 1, 'net_price' => 500, 'vat' => ['id' => $vat22->id]],
        ],
        'ei_data' => ['payment_method' => 'MP05'], // FatturaPA payment method code (MP05 = bank transfer)
    ],
];

$totals = FIC::issuedDocuments()->getNewTotals($body); // Entities\IssuedDocument\IssuedDocumentTotals

$body['data']['payments_list'] = [
    ['amount' => $totals->amountDue, 'due_date' => now()->addDays(30)->toDateString(), 'status' => 'not_paid'],
];

$invoice = FIC::issuedDocuments()->create($body);
```

- Only `data.date` and `data.due_date` are converted to `Y-m-d` for you; format nested dates (like `payments_list.*.due_date`) yourself.
- `payments_list.*.status` is `not_paid`, `paid` or `reversed`. A `paid` payment also needs `payment_account` with an `id`.
- Use an existing client with `'entity' => ['id' => $clientId, ...]`; the API does not autocomplete the entity from the ID, so still send the fields above.

## 3. Verify, then send to SDI

```php
$check = FIC::issuedEInvoices()->verifyXML($invoice->id);
// On failure: an Error whose ->error->validation_result lists the XML problems.

$sent = FIC::issuedEInvoices()->send($invoice->id, [
    'data' => [],
    'options' => ['dry_run' => true], // runs every check without dispatching; remove to really send
]);
```

`dry_run` requires e-invoicing to be active on the Fatture in Cloud account.

## 4. Track the status

```php
$document = FIC::issuedDocuments()->detail($invoice->id, ['fieldset' => 'detailed']);
$document->eiStatus; // e.g. sent, processing, accepted, rejected, discarded, not_delivered, error

if ($document->eiStatus === 'rejected') {
    $reason = FIC::issuedEInvoices()->getRejectionReason($invoice->id);
}
```

Instead of polling, you can subscribe a webhook (`FIC::webhooks()->create(...)`) to the event `it.fattureincloud.webhooks.issued_documents.e_invoices.status_update`.

## Do not

- Do not retry 403 responses (missing scope, expired license or exhausted quota); 429 is already retried by the package.
- Do not send amounts with more than 2 decimals and expect them to match the total.
- Do not build the e-invoice XML yourself; Fatture in Cloud generates it from the document.

Reference: https://developers.fattureincloud.it/docs/guides/invoice-creation/ and https://developers.fattureincloud.it/docs/guides/e-invoice-management/
