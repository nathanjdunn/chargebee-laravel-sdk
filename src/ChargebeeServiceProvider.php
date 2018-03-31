<?php

namespace NathanDunn\ChargebeeLaravel;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use NathanDunn\Chargebee\Client;

class ChargebeeServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__ . '/../config/chargebee.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('chargebee.php')]);
        }

        $this->mergeConfigFrom($source, 'chargebee');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    /**
     * Register the factory class.
     *
     * @return void
     */
    protected function registerFactory()
    {
        $this->app->singleton('chargebee.factory', function () {
            return new chargebeeFactory();
        });
        $this->app->alias('chargebee.factory', chargebeeFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('chargebee', function (Container $app) {
            $config = $app['config'];
            $factory = $app['chargebee.factory'];
            return new ChargebeeManager($config, $factory);
        });
        $this->app->alias('chargebee', chargebeeManager::class);
    }

    /**
     * Register the bindings.
     *
     * @return void
     */
    protected function registerBindings()
    {
        $this->app->bind('chargebee.connection', function (Container $app) {
            $manager = $app['chargebee'];
            return $manager->connection();
        });
        $this->app->alias('chargebee.connection', Client::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            'chargebee',
            'chargebee.factory',
            'chargebee.connection',
        ];
    }
}