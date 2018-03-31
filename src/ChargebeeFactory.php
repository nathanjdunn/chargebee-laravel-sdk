<?php

namespace NathanDunn\ChargebeeLaravel;

use InvalidArgumentException;
use NathanDunn\Chargebee\Client;
use NathanDunn\Chargebee\HttpClient\Builder;

class ChargebeeFactory
{
    /**
     * Make a new Chargebee client.
     *
     * @param array $config
     *
     * @return Client
     */
    public function make(array $config): Client
    {
        $config = $this->getConfig($config);

        return $this->getClient($config);
    }


    /**
     * Get the configuration data.
     *
     * @param array $config
     *
     * @return array
     */
    protected function getConfig(array $config): array
    {
        $keys = ['key', 'site'];

        foreach ($keys as $key) {
            if (!array_key_exists($key, $config)) {
                throw new InvalidArgumentException("Missing configuration key [$key].");
            }
        }
        return array_only($config, ['key', 'site', 'client']);
    }


    /**
     * Get the main client.
     *
     * @param array $config
     *
     * @return Client
     */
    protected function getClient(array $config): Client
    {
        $client = isset($config['client']) ? new $config['client'] : null;
        $builder = new Builder($config['key'], $client);

        $client = new Client($config['site'], $config['key'], $builder);

        return $client;
    }
}