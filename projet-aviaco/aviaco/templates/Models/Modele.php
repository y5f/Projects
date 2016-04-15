<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Modele {

    private $host;
    function __construct() {
        if(isset($_GET['url'])){
            $this->host='?url='.$_GET['url'].'&lien=';
        }else{
            $this->host='?url=';
        }
        
    }
    
    /*
     * --- Cette méthode retourne un model de type accueil --- 
     */
    function get_accueil_model() {
        $mon_accueil=new Middle();
        $mon_accueil->getContents();
    }
    
    function get_serv_map_model(){
        $form_portfolio=new Hgroup();
        $form_portfolio->setAttribute('class', 'port-form');
        $form_portfolio->addElement(new Text('Vos Map règlementation ici .....'));
        
        $mon_portfolio=new Portfolio($form_portfolio,'--- Page en construction ---','capt-folio','map.png');
        return $mon_portfolio->getPortfolio();
    }
    function get_serv_map_reg_model(){
        $form_portfolio=new Hgroup();
        $form_portfolio->setAttribute('class', 'port-form');
        $form_portfolio->addElement(new Text('Map règlementation ici .....'));
        
        $mon_portfolio=new Portfolio($form_portfolio,'Bonjour le monde ...','capt-folio','img_2.jpg');
        return $mon_portfolio->getPortfolio();
    }
    function get_serv_map_mro_model(){
        $form_portfolio=new Hgroup();
        $form_portfolio->setAttribute('class', 'port-form');
        $form_portfolio->addElement(new Text('Map MRO ici .....'));
        
        $mon_portfolio=new Portfolio($form_portfolio,'Bonjour le monde ...','capt-folio','img_2.jpg');
        return $mon_portfolio->getPortfolio();
    }
    function get_serv_map_part_model(){
        $form_portfolio=new Hgroup();
        $form_portfolio->setAttribute('class', 'port-form');
        $form_portfolio->addElement(new Text('Map Partenaire ici .....'));
        
        $mon_portfolio=new Portfolio($form_portfolio,'Bonjour le monde ...','capt-folio','img_2.jpg');
        return $mon_portfolio->getPortfolio();
    }


}
