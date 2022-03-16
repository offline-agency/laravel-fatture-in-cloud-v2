<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities;

abstract class AbstractEntity
{
    public function __construct($parameters)
    {
        if (is_null($parameters)) {
            return null;
        }

        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->build($parameters);
    }

    public function build(array $parameters): void
    {
        foreach ($parameters as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }
}
