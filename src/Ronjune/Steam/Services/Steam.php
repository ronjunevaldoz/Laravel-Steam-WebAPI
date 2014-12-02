<?php

namespace Ronjune\Steam\Services;

class Steam {


    public function __construct() {
    }

    public function user() {
        return new SteamUser();
    }

}
