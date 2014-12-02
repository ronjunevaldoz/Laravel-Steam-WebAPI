<?php

namespace Ronjune\Steam\Facades;

use Illuminate\Support\Facades\Facade;

class SteamUtil extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'steam_util';
    }

}
