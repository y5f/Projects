<?php


class Pied {
    private $footer;
   function __construct()
    {
      $this->footer=new Footer();
      
    }
    
    function getFooter()
    {
        echo  $this->footer->toHTML();
    }
}
