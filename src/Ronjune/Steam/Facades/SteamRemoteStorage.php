<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SteamRemoteStorage
 *
 * @author Ron June Lopez <ronjune.lopez@gmail.com>
 */

namespace Ronjune\Steam\Facades;


use Illuminate\Support\Facades\Facade;

class SteamRemoteStorage extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'steam_remote_storage';
    }

}