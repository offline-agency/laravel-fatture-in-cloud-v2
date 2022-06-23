<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Traits;

trait ListTrait
{
    public function hasItems(): bool
    {
        return count($this->getItems()) > 0;
    }
}
