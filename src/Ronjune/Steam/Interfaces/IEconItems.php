<?php

/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 2:57 PM
 */

namespace Ronjune\Steam\Interfaces;

interface IEconItems {

    public function getPlayerItems($steamid);

    public function getSchema();

    public function getSchemaURL();

    public function getStoreMetaData();
}
