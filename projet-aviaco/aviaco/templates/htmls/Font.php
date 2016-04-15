<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Font {

    private $fonts;
    
    function __construct() {
        
        $this->abeezee();
        $this->lato();
        $this->montserrat();
        $this->open_sans();
        $this->open_sans_condensed();
        $this->oswald();
        $this->roboto();

    }
    
    function oswald() {
        $link=new Link();
        $link->setAttribute('href', 'http://fonts.googleapis.com/css?family=Oswald');
        $this->fonts[]=$link;
        //return $this->$link->toHTML();
    }

    function open_sans() {
        $link=new Link();
        $link->setAttribute('href', 'http://fonts.googleapis.com/css?family=Open Sans');
        $this->fonts[]=$link;
        //return $this->$link->toHTML();
    }

    function open_sans_condensed() {
        $link=new Link();
        $link->setAttribute('href', 'http://fonts.googleapis.com/css?family=Open Sans Condensed');
        $this->fonts[]=$link;
        //return $this->$link->toHTML();
    }

    function lato() {
        $link=new Link();
        $link->setAttribute('href', 'http://fonts.googleapis.com/css?family=Lato');
        $this->fonts[]=$link;
        //return $this->$link->toHTML();
    }

    function montserrat() {
        $link=new Link();
        $link->setAttribute('href', 'http://fonts.googleapis.com/css?family=Montserrat');
        $this->fonts[]=$link;
        //return $this->$link->toHTML();
    }

    function roboto() {
        $link=new Link();
        $link->setAttribute('href', 'http://fonts.googleapis.com/css?family=Roboto');
        $this->fonts[]=$link;
        //return $this->$link->toHTML();
    }

    function abeezee() {
        $link=new Link();
        $link->setAttribute('href', 'http://fonts.googleapis.com/css?family=ABeeZee');
        $this->fonts[]=$link;
        //return $this->$link->toHTML();
    }

    function getFonts() {
        foreach ($this->fonts as $f) {
            echo $f->toHTML();
        }
    }

}
