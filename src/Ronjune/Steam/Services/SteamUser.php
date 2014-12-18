<?php

/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 11:34 AM
 */

namespace Ronjune\Steam\Services;

use Ronjune\Steam\Services\SteamWebAPI;
use Ronjune\Steam\Interfaces\ISteamUser;

class SteamUser extends SteamWebAPI implements ISteamUser {

    public function __construct() {
        parent::__construct();
        $this->setInterface('ISteamUser');
    }

    public function getFriendList($steamid = '', $relationship = '') {
        $parameters = [
        'steamid' => $steamid
        ];

        return  $this->get('', __FUNCTION__, 1, $parameters);
    }

    public function getPlayerBans($steamids = '') {
        $parameters = [
        'steamids' => $steamids
        ];

        return $this->get('', __FUNCTION__, 1, $parameters);
    }

    public function getPlayerSummaries($steamids) {
        $parameters = [
        'steamids' => $steamids
        ];
        $request = $this->get('', __FUNCTION__, 2, $parameters);
        return is_object($request) ? $request->response->players : null;
    }

    public function getUserGroupList($steamid) {
        $parameters = [
        'steamid' => $steamid
        ];

        return $this->get('', __FUNCTION__, 1, $parameters);
    }

    public function resolveVanityURL($vanityurl, $url_type) {
        $parameters = [
        'vanityurl' => $vanityurl,
        'url_type' => $url_type
        ];

        return $this->get('', __FUNCTION__, 1, $parameters);
    }

}
