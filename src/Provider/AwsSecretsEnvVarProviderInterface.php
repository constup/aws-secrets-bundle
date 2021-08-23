<?php

declare(strict_types = 1);

namespace AwsSecretsBundle\Provider;

interface AwsSecretsEnvVarProviderInterface
{
    /**
     * @param string $name
     *
     * @return string
     */
    public function get(string $name): string;
}
