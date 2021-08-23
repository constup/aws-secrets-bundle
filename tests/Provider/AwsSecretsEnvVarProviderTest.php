<?php

namespace Constup\AwsSecretsBundle\Tests\Provider;

use Aws\Result;
use Aws\SecretsManager\SecretsManagerClient;
use Constup\AwsSecretsBundle\Provider\AwsSecretsEnvVarProvider;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class AwsSecretsEnvVarProviderTest extends TestCase
{
    use ProphecyTrait;

    private $secretsManagerClient;
    private $provider;

    protected function setUp(): void
    {
        $this->secretsManagerClient = $this->prophesize(SecretsManagerClient::class);
        $this->provider = new AwsSecretsEnvVarProvider($this->secretsManagerClient->reveal());
    }

    /** @test */
    public function it_gets_value_from_secrets_manager(): void
    {
        $result = $this->prophesize(Result::class);
        $this->secretsManagerClient->getSecretValue([AwsSecretsEnvVarProvider::AWS_SECRET_ID => 'key'])->willReturn($result);
        $result->get(AwsSecretsEnvVarProvider::AWS_SECRET_STRING)->willReturn('value');

        $result = $this->provider->get('key');

        $this->assertEquals('value', $result);
    }
}
