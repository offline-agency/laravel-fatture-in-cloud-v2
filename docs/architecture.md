# Architecture

## Package Structure

```
src/
├── Api/                    # 20 API resource classes + base Api + ApiResponse
│   ├── Api.php             # Base: get/post/put/destroy, retry, throttle
│   ├── ApiResponse.php     # Typed response DTO (success, data)
│   ├── Client.php          # Example: list, all, detail, create, edit, delete
│   └── ...                 # 18 more resource classes
├── Console/                # Artisan commands
│   ├── TestConnectionCommand.php
│   └── ApiStatusCommand.php
├── Contracts/              # Interfaces
│   ├── ConnectorInterface.php
│   └── FattureInCloudManagerInterface.php
├── Entities/               # Readonly value objects (85+ files)
│   ├── Client/Client.php, ClientList.php, ClientPagination.php
│   ├── Pagination.php      # Base pagination
│   └── Error.php
├── Enums/                  # String-backed enums
│   ├── IssuedDocumentType.php
│   ├── ReceivedDocumentType.php
│   └── ReceiptType.php
├── Traits/
│   ├── ListTrait.php       # Recursive auto-pagination (getAll)
│   └── NormalizesDatesTrait.php
├── FattureInCloud.php      # Connector: credentials, HTTP client
├── FattureInCloudManager.php  # Fluent entry point (Facade target)
└── LaravelFattureInCloudV2ServiceProvider.php
```

## Request Lifecycle

```
App → Facade/Manager → Api\Client → Api (base) → FattureInCloud → Laravel Http → FIC API
                                        ↓
                                   ApiResponse
                                        ↓
                              Entity hydration (readonly)
```

1. **Entry**: `LaravelFattureInCloudV2::clients()->list()` resolves Manager from container
2. **Manager**: `clients()` creates `new Client($connector)` with the current connector
3. **Api method**: `Client::list()` validates params, calls `$this->get($url, $params)`
4. **Base Api**: `get()` wraps HTTP call in `executeWithRetry()` closure
5. **Connector**: `FattureInCloud::getRequest()` returns `PendingRequest` with token + baseUrl
6. **Retry**: On 403/429, exponential backoff up to `max_retries` (default 3)
7. **Response**: `ApiResponse(success, data)` — typed DTO replaces bare object
8. **Entity**: `new ClientEntity($response->data->data)` — readonly value object

## Entity Mapping

API JSON → `stdClass` via `json_decode` → Entity constructor → camelCase readonly properties

```php
// API response: {"id": 1, "vat_number": "IT123", "created_at": "2024-01-01"}
// Entity:       $client->id === 1, $client->vatNumber === "IT123", $client->createdAt === "2024-01-01"
```

## Retry / Throttle Flow

```
executeWithRetry(closure)
  ├── attempt 1: call API
  │   └── 403/429? → waitThrottle(base * 2^0) → retry
  ├── attempt 2: call API
  │   └── 403/429? → waitThrottle(base * 2^1) → retry
  ├── attempt 3 (max): call API
  │   └── 403/429? → return ApiResponse(success=false)
  └── 2xx: return ApiResponse(success=true)
```

Backoff delays (configurable via `config/fatture-in-cloud-v2.php`):
- 403: base 300ms, then 600ms
- 429: base 3.6s, then 7.2s

## Multi-Company Resolution

```
FattureInCloud constructor resolution order:
1. Explicit $companyId / $accessToken parameters
2. Named company: config('fatture-in-cloud-v2.companies.{name}')
3. Default company: config('fatture-in-cloud-v2.companies.default')
4. First company in config array

Manager.forCompany('acme') → clones Manager with new FattureInCloud(companyName: 'acme')
```

## Testing Strategy

- **Fake responses**: 85+ `*FakeResponse` builder classes in `tests/Fake/`
- **HTTP mocking**: `Http::fake()` per-test with specific URL patterns
- **Architecture**: Pest arch tests enforce strict_types, readonly, no debug, isolation
- **Coverage**: `covers()` on every describe block for precise per-class tracking
