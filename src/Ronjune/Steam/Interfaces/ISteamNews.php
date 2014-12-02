<?php

/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 3:04 PM
 */

namespace Ronjune\Steam\Interfaces;

interface ISteamNews {

    public function getNewsForApp($appid, $maxlength, $enddate, $count, $feeds);
}
