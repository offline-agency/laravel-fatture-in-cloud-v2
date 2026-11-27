## Fatture in Cloud (offline-agency/laravel-fatture-in-cloud-v2)

This package is the Laravel SDK for the Fatture in Cloud API v2 (Italian invoicing and e-invoicing / SDI). Use it for every Fatture in Cloud call instead of raw HTTP requests or the generic `fattureincloud/fattureincloud-php-sdk`.

### Calling the API

- Use the facade `OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade` (conventionally imported `as FIC`) or inject `OfflineAgency\LaravelFattureInCloudV2\Contracts\FattureInCloudManagerInterface`.
- Accessors: `clients()`, `suppliers()`, `products()`, `issuedDocuments()`, `issuedEInvoices()`, `receivedDocuments()`, `receipts()`, `taxes()`, `archive()`, `cashbook()`, `info()`, `priceLists()`, `webhooks()`, `emails()`, `situation()`, `vatTypes()`, `paymentAccounts()`, `paymentMethods()`, `company()`, `users()`.
- Use enums for document types: `Enums\IssuedDocumentType`, `Enums\ReceivedDocumentType`, `Enums\ReceiptType`.
- `all()` returns every page as an array of entities; `list()` returns one page with `getItems()` and `getPagination()`.
- Request bodies follow the Fatture in Cloud API reference and are wrapped in `data`. Dates may be `Carbon`/`DateTime`; they are sent as `Y-m-d`.

@verbatim
<code-snippet name="List and create documents" lang="php">
use OfflineAgency\LaravelFattureInCloudV2\Enums\IssuedDocumentType;
use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade as FIC;

$invoices = FIC::issuedDocuments()->all(IssuedDocumentType::Invoice);

$invoice = FIC::issuedDocuments()->create([
    'data' => [
        'type' => IssuedDocumentType::Invoice->value,
        'entity' => ['name' => 'Mario Rossi S.r.l.'],
        'date' => now(),
        'items_list' => [['name' => 'Consulting', 'qty' => 1, 'net_price' => 500]],
    ],
]);
</code-snippet>
@endverbatim

### Results are not exceptions

API methods never throw on API errors. Always narrow the return type before using it:

- `Illuminate\Support\MessageBag`: the body failed local validation; nothing was sent.
- `OfflineAgency\LaravelFattureInCloudV2\Entities\Error`: the API returned an error; details are in `$result->error`.
- Otherwise: a readonly entity with camelCase properties (`$invoice->amountGross`, `$client->vatNumber`).

@verbatim
<code-snippet name="Handle every result type" lang="php">
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;

$client = FIC::clients()->create(['data' => ['name' => 'ACME S.p.A.']]);

if ($client instanceof MessageBag || $client instanceof Error) {
    // handle the failure; do not read entity properties here
}
</code-snippet>
@endverbatim

### Configuration and companies

- Credentials come from `config/fatture-in-cloud-v2.php` (`FCV2_DEFAULT_ID`, `FCV2_DEFAULT_BEARER` in `.env`). Never hard-code tokens.
- Switch company with `FIC::forCompany('name')`. An unknown name, or a missing ID/token when a request is sent, throws `Exceptions\ConfigurationException`.
- Check credentials with `php artisan fic:test-connection`.

### Rate limits

- Do not write your own retry or `sleep()` loops. HTTP 429 is retried automatically using `Retry-After`, capped by `limits.max_wait`.
- HTTP 403 (missing scope, expired license, exhausted hourly/monthly quota) is returned as an `Error` and is not retried. In queued jobs, release the job for later instead of retrying immediately.

### Testing

Requests use Laravel's HTTP client, so fake them with `Http::fake()`. Set fake credentials first, or a `ConfigurationException` is thrown before the fake is reached.

@verbatim
<code-snippet name="Fake the API in tests" lang="php">
config([
    'fatture-in-cloud-v2.companies.default.id' => '1',
    'fatture-in-cloud-v2.companies.default.bearer' => 'test-token',
]);

Http::fake([
    'api-v2.fattureincloud.it/c/*/entities/clients*' => Http::response(['data' => [['id' => 1, 'name' => 'ACME']]]),
]);
</code-snippet>
@endverbatim
