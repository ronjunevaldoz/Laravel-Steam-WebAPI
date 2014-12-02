<?php
/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 12:01 PM
 */

namespace Ronjune\Steam\Facades;


use Illuminate\Support\Facades\Facade;

class SteamWebAPI extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'steamwebapi';
    }

}
