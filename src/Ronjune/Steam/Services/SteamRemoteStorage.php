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

namespace Ronjune\Steam\Services;

use Ronjune\Steam\Services\SteamWebAPI;
use Ronjune\Steam\Interfaces\ISteamRemoteStorage;

class SteamRemoteStorage extends SteamWebAPI implements ISteamRemoteStorage {

    public function __construct() {
        parent::__construct();
        $this->setInterface('ISteamRemoteStorage');
    }

    public function getCollectionDetails($collectioncount, $publishedfileids) {
        
    }

    public function getPublishedFileDetails($itemcount, $publishedfileids) {
        
    }

    public function getUGCFileDetails($ugcid = '', $steamid = '', $appid = '570') {
        $parameters = [
            'steamid' => $steamid,
            'ugcid' => $ugcid,
            'appid' => $appid
        ];
        $request = $this->setMethod(__FUNCTION__)->setVersion('v0001')->setParams($parameters)->get();
        
        return is_object($request) && isset($request->data) ? $request->data : null;
    }

}
