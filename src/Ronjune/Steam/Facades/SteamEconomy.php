<?php
/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 10:59 PM
 */

namespace Ronjune\Steam\Facades;


use Illuminate\Support\Facades\Facade;

class SteamEconomy extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'steameconomy';
    }

}