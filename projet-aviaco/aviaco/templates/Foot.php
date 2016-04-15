<?php

/* 
 * Cette classe permet la personnalisation du pied de page
 * du site
 */
class Foot {
    
    function __construct() {
       
    }
    
    function getFoot() {
        $bloc_foot=new Footer();
        
        $row_foot=new Div();
        $row_foot->setAttribute('class', 'row');
        //$bloc_foot->addElement($row_foot);
        
        $foot=new Div();
        $foot->setAttribute('class', 'foot col-xs-12 col-sm-12 col-md-12');
        
        //--- LES MENUS EN DETAILS ----//
        $wrapper=new Div();
        $wrapper->setAttribute('class', 'wrapper');
        
        $bloc_menu=new Hgroup();
        $bloc_menu->setAttribute('class', 'b-menu');
        
        
        $bas_menu=new Menu();
        $bas_menu->setAttribute('class', 'bas-menu');
        $bloc_menu->addElement($bas_menu->getMenu());
        //$foot->addElement($wrapper);
        
        //--- Bloc entre les menu et les icone reseau sociaux ---
        $bloc_libre=new Div();
        $bloc_libre->setAttribute('class', 'lbr');
        $bloc_menu->addElement($bloc_libre);
        
        //---- PERSONNALISATION PIED DE PAGE -----//
        $soc_wrapper=new Div();
        $soc_wrapper->setAttribute('class', 'soc-wrapper');
        
        //--- RESEAUX SOCIAL ------//
        $sociale=new Div();
        $sociale->setAttribute('class', 'network');
        
        $fc=new Figure();
        $capt_f=new P();
        $capt_f->addElement(new Text('facebook'));
        $fc->add(Array('src'=>'upload/fcbk.png','capt'=>$capt_f));
        $a_f=new A($fc, 'https://www.facebook.com/pages/Aviaco-France/1574058822877323?pnref=lhc');
        
        $tw=new Figure();
        $capt_t=new P();
        $capt_t->addElement(new Text('twitter'));
        $tw->add(Array('src'=>'upload/twit.png','capt'=>$capt_t));
        $a_t=new A($tw, 'https://twitter.com/Aviacofrance');
        
        
        $gplus=new Figure();
        $capt_g=new P();
        $capt_g->addElement(new Text('google+'));
        $gplus->add(Array('src'=>'upload/gplus.png','capt'=>$capt_g));
        $a_gp=new A($gplus, 'http://www.google.com/intl/fr/+/learnmore');
        
        $link=new Figure();
        $capt_l=new P();
        $capt_l->addElement(new Text('link'));
        $link->add(Array('src'=>'upload/link.png','capt'=>$capt_l));
        $a_lk=new A($link, 'https://fr.linkedin.com');
        
        $sociale->addElements(Array($a_f,$a_t,$a_gp,$a_lk));
        
        $soc_wrapper->addElement($sociale);
        
        //--- Les mention légale et copyright aviaco ----
        $legal=new Div();
        $legal->setAttribute('class', 'legal');
        
        $site_map=new H3();
        $site_map->addElement(new Text('Site Map'));
        //$legal->addElement($site_map);
        
        $copy=new Label('copy');
        $copy->setAttribute('class', 'copy');
        $copy->addElement(new Text('@ Aviaco-france 2015'));
        
        $condition=new Label('cond');
        $condition->setAttribute('class', 'cond');
        $url=new A(new Text('Termes & conditions'), '?#');
        $condition->addElement($url);
        
        $legal->addElements(Array($copy,$condition));
        
        $wrapper->addElement($bloc_menu);
        $wrapper->addElements(Array($soc_wrapper,$legal));
        $foot->addElement($wrapper);
        
        $bloc_foot->addElement($foot);
        echo $bloc_foot->toHTML();
        
    }
}