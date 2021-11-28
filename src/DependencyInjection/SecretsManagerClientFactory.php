<?php

declare(strict_types = 1);

namespace Constup\AwsSecretsBundle\DependencyInjection;

use Aws\SecretsManager\SecretsManagerClient;
use Exception;

class SecretsManagerClientFactory
{
    /**
     * @param string      $region
     * @param null|string $key
     * @param null|string $secret
     * @param null|string $version
     *
     * @throws Exception
     *
     * @return SecretsManagerClient
     */
    public static function createClient(
        string $region,
        string $version,
        ?string $endpoint, 
        ?string $key,
        ?string $secret
    ): SecretsManagerClient {
        $config = [
            'region' => $region,
            'version' => $version,
        ];

        if ($key && $secret) {
            $config['credentials'] = [
                'key' => $key,
                'secret' => $secret,
            ];
        } elseif (($key && !$secret) || (!$key && $secret)) {
            throw new Exception('Both key and secret must be provided or neither');
        }

        if ($endpoint) {
            $config['endpoint'] = $endpoint;
        }

        return new SecretsManagerClient($config);
    }
}
