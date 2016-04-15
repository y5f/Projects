<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Link extends ElementVide {

    function __construct() {
        parent::__construct();
        $this->setAttribute('rel', 'stylesheet');
        $this->setAttribute('type', 'text/css');
    }

}