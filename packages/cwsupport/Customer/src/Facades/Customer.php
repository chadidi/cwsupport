<?php

namespace cwsupport\Customer\Facades;

use Illuminate\Support\Facades\Facade;

class Customer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'customer';
    }
}
