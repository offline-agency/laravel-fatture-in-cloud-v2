<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Exceptions;

use InvalidArgumentException;

/**
 * Thrown when the package is misconfigured (unknown company, missing ID or token),
 * so the problem surfaces locally instead of as an opaque 401 from the API.
 */
class ConfigurationException extends InvalidArgumentException
{
    public static function unknownCompany(string $companyName): self
    {
        return new self(sprintf(
            "Company '%s' is not configured. Add it under 'companies' in config/fatture-in-cloud-v2.php.",
            $companyName,
        ));
    }

    public static function missingCredential(string $credential, ?string $companyName): self
    {
        $field = $credential === 'id' ? 'company ID' : 'access token (bearer)';

        if ($companyName === 'default') {
            $envKey = $credential === 'id' ? 'FCV2_DEFAULT_ID' : 'FCV2_DEFAULT_BEARER';

            return new self(sprintf(
                'Fatture in Cloud %s is missing. Set companies.default.%s in config/fatture-in-cloud-v2.php (read from %s in .env by default).',
                $field,
                $credential,
                $envKey,
            ));
        }

        if ($companyName !== null) {
            return new self(sprintf(
                "Fatture in Cloud %s is missing for company '%s'. Set companies.%s.%s in config/fatture-in-cloud-v2.php.",
                $field,
                $companyName,
                $companyName,
                $credential,
            ));
        }

        return new self(sprintf(
            'Fatture in Cloud %s is missing. Configure a company in config/fatture-in-cloud-v2.php or pass it to the FattureInCloud constructor.',
            $field,
        ));
    }
}
