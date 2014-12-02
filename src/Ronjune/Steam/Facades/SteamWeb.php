<?php

namespace Ronjune\Steam\Facades;

use Illuminate\Support\Facades\Facade;

class SteamWeb extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'steamweb';
    }

}
