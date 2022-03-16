<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use Illuminate\Support\Arr;

class FakeResponse
{
    public function value(
        array  $params,
        string $key,
               $default
    )
    {
        return Arr::has($params, $key)
            ? Arr::get($params, $key)
            : $default;
    }
}
