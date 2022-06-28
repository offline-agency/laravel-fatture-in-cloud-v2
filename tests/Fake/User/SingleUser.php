<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\User;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SingleUser extends FakeResponse
{
    public function getUserFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'data.id', 1),
            'name' => $this->value($params, 'data.name', 'fake_name'),
            'first_name' => $this->value($params, 'data.first_name', 'fake_first_name'),
            'last_name' => $this->value($params, 'data.last_name', 'fake_last_name'),
            'email' => $this->value($params, 'data.email', 'fake_code@gmail.com'),
            'hash' => $this->value($params, 'data.hash', 'fake_hash'),
            'picture' => $this->value($params, 'data.picture', 'fake_picture'),
        ];
    }
}
