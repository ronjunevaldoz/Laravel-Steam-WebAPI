<?php

/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 3:05 PM
 */

namespace Ronjune\Steam\Interfaces;

interface ISteamRemoteStorage {

    public function getCollectionDetails($collectioncount, $publishedfileids);

    public function getPublishedFileDetails($itemcount, $publishedfileids);

    public function getUGCFileDetails($steamid, $ugcid, $appid);
}
