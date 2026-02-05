<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Situation\Situation as SituationEntity;

class Situation extends Api
{
    public function getSituation(array $additionalData = []): SituationEntity|Error
    {
        $additionalData = $this->data($additionalData, [
            'year',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/get/situation',
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $situation = $response->data->data;

        return new SituationEntity($situation);
    }
}
