<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Fieldset extends ElementNonVide {

    function __construct($legend) {
        parent::__construct();
        $this->addElement(new Legend($legend));
    }

}