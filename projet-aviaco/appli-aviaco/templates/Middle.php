<?php
class Middle {

    private $contenu;
    function __construct() {
        
        //------ Creation du bloc au milieu ---//

        $this->contenu=new Section();
        $this->contenu->setAttribute('class', 'middle');
        
        //--- On crée l'objet qui va fournir le contenu adéquat --//
        $path=new PATH();
        if($path){
            $this->contenu->addElement($path->getForm());
        }
    }
    function getContenu() {
        echo $this->contenu->toHTML();
    }
}

