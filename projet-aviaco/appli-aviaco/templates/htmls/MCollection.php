<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class MCollection {

    private $url;
    private static $mcollection;
    function __construct() {
        //
    }
    static function getMCollection(){
        if(is_null(self::$mcollection)){
            self::$mcollection=new MCollection();
        }
        return self::$mcollection;
    }
    function getURL($key) {
        return $this->url[$key];
    }
    function addURL($key,$url) {
        $this->url[$key]=$url;
    }

}

