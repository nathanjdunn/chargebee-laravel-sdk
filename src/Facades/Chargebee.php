<?php namespace NathanDunn\ChargebeeLaravel;

use Illuminate\Support\Facades\Facade;

class Chargebee extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'chargebee';
    }
}