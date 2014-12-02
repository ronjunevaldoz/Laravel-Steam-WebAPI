<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ISteamWebAPIUtil
 *
 * @author R0N
 */

namespace Ronjune\Steam\Interfaces;

interface ISteamWebAPIUtil {
   public function getServerInfo();
   public function getSupportedAPIList();
}
