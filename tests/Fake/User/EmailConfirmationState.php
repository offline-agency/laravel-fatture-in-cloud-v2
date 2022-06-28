<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\User;

use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class EmailConfirmationState extends FakeResponse
{
    public function getEmailConfirmationStateFakeDetail(
        array $params = []
    ): array {
        return [
            'need_confirmation' => $this->value($params, 'email_confirmation_state.need_confirmation', false),
        ];
    }
}
