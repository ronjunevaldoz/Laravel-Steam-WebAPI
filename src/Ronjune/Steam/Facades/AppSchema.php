<?php

namespace Ronjune\Steam\Facades;

use Illuminate\Support\Facades\Facade;

class AppSchema extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'appschema';
    }

}
