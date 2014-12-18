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

        $request =  $this->get('', __FUNCTION__, 1, $parameters);

        // status 15 statusDetail Permission Denied
        // if(is_object($request)   &&  isset($request->result)){
        //     return $request->result;
        //     // if($result->status == 1){
        //     //     return $result->items;
        //     // } else if($result->status == 15){
        //     //     return $result->statusDetail;
        //     // }
        // }

        return is_object($request)   &&  isset($request->result)  ? $request->result : null;
    }

//@ TODO getSchema should download only the file and will be used in table seeder
    public function getSchema( $filename='') {
          $this->get('', __FUNCTION__, 1, [], $filename);

    }

    public function getSchemaURL() {
        return $this->get('', __FUNCTION__, 1);
    }

    public function getStoreMetaData() {
        return $this->get('', __FUNCTION__, 1);
    }

}
