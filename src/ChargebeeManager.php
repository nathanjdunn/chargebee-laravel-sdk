<?php

namespace NathanDunn\ChargebeeLaravel;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;
use NathanDunn\Chargebee\Client;

class ChargebeeManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @var ChargebeeFactory
     */
    protected $factory;

    /**
     * Create a new Chargebee manager instance.
     *
     * @param Repository $config
     * @param ChargebeeFactory $factory
     *
     * @return void
     */
    public function __construct(Repository $config, ChargebeeFactory $factory)
    {
        parent::__construct($config);

        $this->factory = $factory;
        $this->config = $config;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return Client
     */
    protected function createConnection(array $config): Client
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName(): string
    {
        return 'chargebee';
    }

    /**
     * Get the factory instance.
     *
     * @return ChargebeeFactory
     */
    public function getFactory(): ChargebeeFactory
    {
        return $this->factory;
    }
}