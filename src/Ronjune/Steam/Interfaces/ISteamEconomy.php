<?php

/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 3:01 PM
 */

namespace Ronjune\Steam\Interfaces;

interface ISteamEconomy {

    public function getAssetClassInfo($appid, $language, $class_count, $classid0, $instanceid0);

    public function getAssetPrices($appid, $currency, $language);
}
