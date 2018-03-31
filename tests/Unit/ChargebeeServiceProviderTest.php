<?php

namespace Tests\Unit;

use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use NathanDunn\Chargebee\Client;
use NathanDunn\ChargebeeLaravel\ChargebeeFactory;
use NathanDunn\ChargebeeLaravel\ChargebeeManager;

class ChargebeeServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    /** @test */
    public function should_assert_chargebee_factory_injectable()
    {
        $this->assertIsInjectable(ChargebeeFactory::class);
    }

    /** @test */
    public function should_assert_chargebee_manager_injectable()
    {
        $this->assertIsInjectable(ChargebeeManager::class);
    }

    public function testBindings()
    {
        $this->assertIsInjectable(Client::class);

        $original = $this->app['chargebee.connection'];
        $this->app['chargebee']->reconnect();
        $new = $this->app['chargebee.connection'];

        $this->assertNotSame($original, $new);
        $this->assertEquals($original, $new);
    }
}