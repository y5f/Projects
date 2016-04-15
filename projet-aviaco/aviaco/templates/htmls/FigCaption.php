<?php

class FigCaption extends ElementNonVide{

    function __construct($capt) {
        parent::__construct();
        $this->addElement(new Text($capt));
    }
    

}
