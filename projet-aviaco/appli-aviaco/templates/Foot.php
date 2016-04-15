<?php

class Foot {

    private $foot;
    function __construct() {
        $this->foot=new Footer();
    }
    function getFooter() {
        echo $this->foot->toHTML();
    }

}
  