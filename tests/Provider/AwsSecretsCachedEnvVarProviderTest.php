<?php

namespace Tests\AwsSecretsBundle\Provider;

use AwsSecretsBundle\Provider\AwsSecretsCachedEnvVarProvider;
use AwsSecretsBundle\Provider\AwsSecretsEnvVarProviderInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

class AwsSecretsCachedEnvVarProviderTest extends TestCase
{
    use ProphecyTrait;

    private $decorated;
    private $provider;
    private $cacheItemPool;

    protected function setUp(): void
    {
        $this->decorated = $this->prophesize(AwsSecretsEnvVarProviderInterface::class);
        $this->cacheItemPool = $this->prophesize(CacheItemPoolInterface::class);
        $this->provider = new AwsSecretsCachedEnvVarProvider(
            $this->cacheItemPool->reveal(),
            $this->decorated->reveal(),
            60
        );
    }

    /** @test */
    public function it_returns_cached_item_if_hit(): void
    {
        $cacheItem = $this->prophesize(CacheItemInterface::class);
        $cacheItem->isHit()->willReturn(true);
        $cacheItem->get()->willReturn('value');
        $this->cacheItemPool->getItem(AwsSecretsCachedEnvVarProvider::CACHE_KEY_PREFIX.'.'.md5('key'))
            ->willReturn($cacheItem);

        $result = $this->provider->get('key');

        $this->assertEquals('value', $result);
    }

    /** @test */
    public function it_sets_cache_item_and_returns_decorated_value_on_no_hit(): void
    {
        $cacheItem = $this->prophesize(CacheItemInterface::class);
        $cacheItem->isHit()->shouldBeCalled()->willReturn(false);
        $cacheItem->set('value')->shouldBeCalled();
        $cacheItem->expiresAfter(60)->shouldBeCalled();
        $this->cacheItemPool->save($cacheItem->reveal())->shouldBeCalled();
        $this->cacheItemPool->getItem(AwsSecretsCachedEnvVarProvider::CACHE_KEY_PREFIX.'.'.md5('key'))
            ->willReturn($cacheItem);
        $this->decorated->get('key')->willReturn('value');

        $result = $this->provider->get('key');
        $this->assertEquals('value', $result);
    }
}
