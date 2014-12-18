<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SteamWebAPIUtil
 *
 * @author R0N
 */

namespace Ronjune\Steam\Services;

use Ronjune\Steam\Services\SteamWebAPI;
use Ronjune\Steam\Interfaces\ISteamWebAPIUtil;

class SteamWebAPIUtil extends SteamWebAPI implements ISteamWebAPIUtil {

    public function __construct() {
        parent::__construct();
        $this->setInterface('ISteamWebAPIUtil');
    }

    public function getServerInfo() {
        return $response = $this->get('', __FUNCTION__, 1, $parameters);
    }

    public function getSupportedAPIList($name = '') {
        $response = $this->get('', __FUNCTION__, 1, $parameters);
        $apilist = $response->apilist;

        foreach ($apilist->interfaces as $index => $interface) {
            if ($name == $interface->name) {
                return $interface;
            }
        }
        return $apilist;
    }

}
