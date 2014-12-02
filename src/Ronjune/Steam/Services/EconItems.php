<?php

/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 7:53 PM
 */

namespace Ronjune\Steam\Services;

use Ronjune\Steam\Services\SteamWebAPI;
use Ronjune\Steam\Interfaces\IEconItems;

class EconItems extends SteamWebAPI implements IEconItems {

    public function __construct() {
        parent::__construct();
        $this->setInterface('IEconItems_' . $this->getAppid());
    }

    public function getPlayerItems($steamid) {

        $parameters = [
            'steamid' => $steamid
        ];

        $request = $this->setMethod(__FUNCTION__)
                        ->setVersion('v0001')
                        ->setParams( $parameters)
                        ->get();

        return is_object($request) ? $request->result->items : null;
    }

//@ TODO getSchema should download only the file and will be used in table seeder
    public function getSchema( $filename='') {
          $this->setMethod(__FUNCTION__)
                        ->setVersion('v0001')
                        ->saveTo($filename)
                        ->get();

    }

    public function getSchemaURL() {
        return $this->setMethod(__FUNCTION__)->get();
    }

    public function getStoreMetaData() {
        return $this->setMethod(__FUNCTION__)->get();
    }

}
