<?php

/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 2:59 PM
 */

namespace Ronjune\Steam\Interfaces;

interface ISteamApps {

    public function getAppList();

    public function getServersAtAddress($addr);

    public function upToDateCheck($appid, $version);
}
