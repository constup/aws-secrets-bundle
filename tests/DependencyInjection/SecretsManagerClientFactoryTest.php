<?php

namespace Constup\AwsSecretsBundle\Tests\DependencyInjection;

use Aws\SecretsManager\SecretsManagerClient;
use Constup\AwsSecretsBundle\DependencyInjection\SecretsManagerClientFactory;
use PHPUnit\Framework\TestCase;

class SecretsManagerClientFactoryTest extends TestCase
{
    /** @test */
    public function it_throws_exception_when_no_secret_but_key_provided(): void
    {
        $this->expectExceptionMessage('Both key and secret must be provided or neither');
        $factory = new SecretsManagerClientFactory();
        $factory->createClient(
            'region',
            'latest',
            null,
            'key',
            null
        );
    }

    /** @test */
    public function it_throws_exception_when_no_key_but_secret_provided(): void
    {
        $this->expectExceptionMessage('Both key and secret must be provided or neither');
        $factory = new SecretsManagerClientFactory();
        $factory->createClient(
            'region',
            'latest',
            null,
            null,
            'secret'
        );
    }

    /** @test */
    public function it_builds_client_without_key_or_secret(): void
    {
        $factory = new SecretsManagerClientFactory();
        $client = $factory->createClient(
            'region',
            'latest',
            null,
            null,
            null
        );
        $this->assertInstanceOf(SecretsManagerClient::class, $client);
    }

    /** @test */
    public function it_builds_client_with_key_and_secret(): void
    {
        $factory = new SecretsManagerClientFactory();
        $client = $factory->createClient(
            'region',
            'latest',
            null,
            'key',
            'secret'
        );
        $this->assertInstanceOf(SecretsManagerClient::class, $client);
    }

    /** @test */
    public function it_builds_client_with_endpoint(): void
    {
        $factory = new SecretsManagerClientFactory();
        $client = $factory->createClient(
            'region',
            'latest',
            'http://my-endpoint.example.com:4566',
            null,
            null
        );
        $this->assertInstanceOf(SecretsManagerClient::class, $client);
    }
}
