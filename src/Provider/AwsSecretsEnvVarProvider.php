<?php

declare(strict_types = 1);

namespace AwsSecretsBundle\Provider;

use Aws\SecretsManager\SecretsManagerClient;

class AwsSecretsEnvVarProvider implements AwsSecretsEnvVarProviderInterface
{
    const AWS_SECRET_ID = 'SecretId';
    const AWS_SECRET_STRING = 'SecretString';
    private $secretsManagerClient;

    public function __construct(SecretsManagerClient $secretsManagerClient)
    {
        $this->secretsManagerClient = $secretsManagerClient;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function get(string $name): string
    {
        return $this->secretsManagerClient
            ->getSecretValue([self::AWS_SECRET_ID => $name])
            ->get(self::AWS_SECRET_STRING);
    }
}
