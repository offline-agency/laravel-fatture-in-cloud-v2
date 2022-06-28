<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\User;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class UserInfo extends FakeResponse
{
    public function getUserInfoFakeDetail(
        array $params = []
    ): array {
        return [
            'need_marketing_consents_confirmation' => $this->value($params, 'info.need_marketing_consents_confirmation', false),
            'need_password_change' => $this->value($params, 'info.need_password_change', false),
            'need_terms_of_service_confirmation' => $this->value($params, 'info.need_terms_of_service_confirmation', false),
        ];
    }
}
