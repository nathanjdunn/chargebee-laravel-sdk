<?php

namespace Tests\Unit;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Illuminate\Contracts\Foundation\Application;
use NathanDunn\ChargebeeLaravel\ChargebeeServiceProvider;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    /**
     * Get the service provider class.
     *
     * @param Application $app
     *
     * @return string
     */
    protected function getServiceProviderClass($app)
    {
        return ChargebeeServiceProvider::class;
    }
}