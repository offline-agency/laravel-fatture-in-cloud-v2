<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\User;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SingleUser extends FakeResponse
{
    public function getUserFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'name' => $this->value($params, 'name', 'fake_name'),
            'first_name' => $this->value($params, 'first_name', 'fake_first_name'),
            'last_name' => $this->value($params, 'last_name', 'fake_last_name'),
            'email' => $this->value($params, 'email', 'fake_code@gmail.com'),
            'hash' => $this->value($params, 'hash', 'fake_hash'),
            'picture' => $this->value($params, 'picture', 'fake_picture'),
        ];
    }
}
