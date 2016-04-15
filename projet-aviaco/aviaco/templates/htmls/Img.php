<?php

class Img extends ElementVide{

    function __construct($src) {
        parent::__construct();
        $this->setAttribute('src', $src);
    }
    

}
