<?php

/* 
 * Cette classe va permettre la gestion du contenu de la page
 */
class Middle{     

    function __construct() {
       
        //
    }
    
	function getContents(){
            
            $section=new Section();
            $section->setAttribute('class', 'b-section');
            
            //---   LES BOUTON MENU FOLLANT SUR LE SLIDER ---//
            $menu=new Div();
            $menu->setAttribute('class', 'menu row');
            $recue_menu=new Menu();
            $menu->addElement($recue_menu->getTop_menu());
            $section->addElement($menu);
                
            //--- AJOUT D'UN SLIDER EN EN INSTANCIANT UN OBJET ----
            $mon_slide=new Slider();
            $slide=$mon_slide->getSlider();
            $section->addElement($slide);
                
            $panneau=new Panneau();
            $section->addElement($panneau->getContents());
            echo $section->toHTML();
            
	}        
}

