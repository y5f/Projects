<?php

class Figure extends ElementNonVide{

    function __construct() {
        parent::__construct();
    }
    
    function addImg($prop) {
        
        $sr=new Img($prop['src']);
        $this->addElement($sr);
          
    }
    
    function addCaption($capt) {

        $this->addElement($capt);
        
    }
    
    function add(Array $prop) {
        
        $this->addImg($prop);
        $this->addCaption($prop['capt']);
       
    }

}
