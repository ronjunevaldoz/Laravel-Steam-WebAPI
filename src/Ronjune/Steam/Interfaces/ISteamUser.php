<?php

/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 11:35 AM
 */

namespace Ronjune\Steam\Interfaces;

interface ISteamUser {

    public function getFriendList($steamid, $relationship);

    public function getPlayerBans($steamids);

    public function getPlayerSummaries($steamids);

    public function getUserGroupList($steamid);

    public function resolveVanityURL($vanityurl, $url_type);
}
