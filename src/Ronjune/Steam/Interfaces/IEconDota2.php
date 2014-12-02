<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IEconDota2_570
 *
 * @author R0N
 */

namespace Ronjune\Steam\Interfaces;

interface IEconDota2 {

    public function getEventStatsForAccount($eventid, $accountid, $language);

    public function getGameItems($language);

    public function getHeroes($language, $itemizedonly);

    public function getItemIconPath($iconname);

    public function getRarities($language);

    public function getTournamentPrizePool($leagueid);
}
