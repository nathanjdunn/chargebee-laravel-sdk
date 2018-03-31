<?php

namespace Tests\Unit;

use Http\Mock\Client as MockClient;
use NathanDunn\Chargebee\Client;
use NathanDunn\ChargebeeLaravel\ChargebeeFactory;

class ChargebeeFactoryTest extends AbstractTestCase
{
    /** @test */
    public function should_get_standard_instance()
    {
        $factory = $this->getChargebeeFactory();

        $return = $factory->make([
            'key' => 'your-key',
            'site' => 'your-site',
            'client' => MockClient::class,
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function should_throw_exception_without_key()
    {
        $factory = $this->getChargebeeFactory();

        $factory->make([
            'site' => 'your-site',
        ]);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function should_throw_exception_without_site()
    {
        $factory = $this->getChargebeeFactory();

        $factory->make([
            'key' => 'your-key',
        ]);
    }

    protected function getChargebeeFactory()
    {
        return new ChargebeeFactory;
    }
}