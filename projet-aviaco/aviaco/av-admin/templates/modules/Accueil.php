<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Accueil {

    private $accueil;
    function __construct() {
        $this->accueil=new Hgroup();
    }
    function getForm() {
        return $this->accueil;
    }

}
