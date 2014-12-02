<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EconDota2_570
 *
 * @author R0N
 */

namespace Ronjune\Steam\Facades;

use Illuminate\Support\Facades\Facade;

class EconDota2 extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'econdota2';
    }

}
