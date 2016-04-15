<?php

/* 
 * Cette classe va decrire l'entête de la page
 */
class Head {
    
    public static $div;
    
    function __construct() {
    
        
    }
     function getHeader() {
        
		//-- On crée une entête a partir de la classe Header de HTML 5---
		$head=new Header();
		
                //--- Un Hgroupe qui va contenir les éleùent di header ---//
                $g_head=new Hgroup();
                $g_head->setAttribute('class', 'g-head');
                
                //---- Gestion bootstrap -----//
                $boot=new Div();
                $boot->setAttribute('class', 'row');
                $col_log=new Div();
                $col_log->setAttribute('class', 'col-xs-12 col-sm-5 col-md-5 col-lg-5');
                $titre=new H1();
                $url_logo=new A(new Img(InfosQuery::create()->findOne()->getLogo()), '?url=aviaco');
                $titre->addElement($url_logo);
                $col_log->addElement($titre);
                
                $col_slog=new Div();
                $col_slog->setAttribute('class', 'hidden-xs col-sm-7 col-md-7 col-lg-7');
                $slogan=new H3();
                $slogan->addElement(new Text(InfosQuery::create()->findOne()->getSlogan()));
                $col_slog->addElement($slogan);
                
                $boot->addElements(Array($col_log,$col_slog));
                $g_head->addElement($boot);
                $head->addElement($g_head);
                
		echo $head->toHTML();
		
    }
    
   

}

