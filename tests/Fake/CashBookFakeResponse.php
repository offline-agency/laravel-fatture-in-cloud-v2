<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\CashBook\TestCashBook;

class CashBookFakeResponse extends FakeResponse
{
    public function getCashBookFakeDetail(
        array $params = []
    ): array{
        return (new TestCashBook())->getFakeCashBook($params);
    }
}
