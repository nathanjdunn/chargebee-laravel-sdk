<?php

namespace Tests\Unit;

use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use Illuminate\Contracts\Config\Repository;
use Mockery;
use NathanDunn\Chargebee\Client;
use NathanDunn\ChargebeeLaravel\ChargebeeFactory;
use NathanDunn\ChargebeeLaravel\ChargebeeManager;

class ChargebeeManagerTest extends AbstractTestBenchTestCase
{
    /** @test */
    public function should_create_connection()
    {
        $config = ['path' => __DIR__];

        $manager = $this->getManager($config);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('chargebee.default')->andReturn('chargebee');

        $this->assertSame([], $manager->getConnections());

        $return = $manager->connection();

        $this->assertInstanceOf(Client::class, $return);
        $this->assertArrayHasKey('chargebee', $manager->getConnections());
    }

    protected function getManager(array $config)
    {
        $repository = Mockery::mock(Repository::class);
        $factory = Mockery::mock(ChargebeeFactory::class);

        $manager = new ChargebeeManager($repository, $factory);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('chargebee.connections')->andReturn(['chargebee' => $config]);

        $config['name'] = 'chargebee';

        $manager->getFactory()->shouldReceive('make')->once()
            ->with($config)->andReturn(Mockery::mock(Client::class));

        return $manager;
    }
}