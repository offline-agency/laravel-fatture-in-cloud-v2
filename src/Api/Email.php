<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\Email\EmailList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;

class Email extends Api
{
    /**
     * List emails (no query params).
     */
    public function list(): EmailList|Error
    {
        $response = $this->get(
            'c/'.$this->companyId.'/emails',
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $emails = $response->data;

        return new EmailList($emails);
    }
}
