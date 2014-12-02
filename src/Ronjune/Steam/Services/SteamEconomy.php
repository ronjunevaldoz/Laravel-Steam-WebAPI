<?php
/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 11:00 PM
 */
namespace Ronjune\Steam\Services;

use Ronjune\Steam\Services\SteamWebAPI;
use Ronjune\Steam\Interfaces\ISteamEconomy;

use Ronjune\Steam\Services\SteamUtil;

class SteamEconomy extends SteamWebAPI implements ISteamEconomy{

    public function __construct(){
        parent::__construct();
        $this->setInterface('ISteamEconomy');
    }

    public function getAssetClassInfo($appid='', $language='', $class_count='', $classid0='', $instanceid0='')
    {


        $parameters = [
        'appid' => $appid,
        'class_count' => $class_count,
        'classid0' => $classid0
        ];



        return $this->setMethod(__FUNCTION__)->setVersion('v0001')->setParams($parameters)->get();
    }


    public function getAssetPrices($appid='', $currency='', $language='')
    {

        $parameters = [
        'appid' => $appid,
        'currency' => $currency
        ];
        
        // this should be constanst
        $filename = $appid.'_assetprices.json';

       $asset_prices_path =  SteamUtil::storage( $filename, $appid);
        if (!file_exists( $asset_prices_path)) {
           ini_set('max_execution_time', 1200);
           $this->setMethod(__FUNCTION__)->setVersion('v0001')->setParams($parameters)->saveTo( $asset_prices_path)->get();
           
       }

       $asset_prices_json =  SteamUtil::getJson( $filename);
       $result = is_null( $asset_prices_json) ? null:  $asset_prices_json->result;
       return !is_null($result) && $result->success ? $result->assets : null;
   }
}