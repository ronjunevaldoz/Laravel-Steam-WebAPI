<?php

/**
 * Description of EconDota2_570
 *
 * @author R0N
 */

namespace Ronjune\Steam\Services\Dota2;

use Ronjune\Steam\Services\SteamWebAPI;
use Ronjune\Steam\Interfaces\IEconDota2;

use Ronjune\Steam\Services\SteamUtil;

class EconDota2 extends SteamWebAPI implements IEconDota2 {

    const APPID = 570;

    public function __construct() {
        parent::__construct();
        $this->setInterface('IEconDota2_' . self::APPID);
    }

    public function getEventStatsForAccount($eventid, $accountid, $language) {
        
    }

    public function getGameItems($language) {
        
    }

    public function getHeroes($language, $itemizedonly) {
        
    }

    public function getItemIconPath($iconname) {
        
    }

    public function getRarities($language = '') {
        $rarities_path =  SteamUtil::storage('rarities', self::APPID);
        if (!file_exists( $rarities_path)) {
            $raritiesJson = $this->setMethod(__FUNCTION__)
                        ->setVersion('v0001')
                        ->saveTo('570_rarities')
                        ->get();
            return null;
        } else {
            $raritiesJson =  SteamUtil::getJson(self::APPID.'_rarities');
            $result = is_null($raritiesJson) ? null: $raritiesJson->result;
            return !is_null($result) && $result->status == 200 ? $result->rarities : null;
        }
    }

    public function getTournamentPrizePool($leagueid) {
        
    }

}
