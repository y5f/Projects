<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Entete {

    private $entete;
    function __construct() {
        
        $this->entete=new Header();
        $this->entete->setAttribute('id', 'h-wrapper');
        
        //--- Bloc d'infos relatives au site ---//
        $bloc_site=new Hgroup();
        $bloc_site->setAttribute('class', 'site-bloc');
        
        $ul_site_infos=new Ul();
        $site_li=new Li(new A(new Text('Aller sur le site'), 'http://aviaco.com'), 'site');
        $site_li->addElement(new Img('upload/capt-logo.png'));
        $ul_site_infos->addLi($site_li);
        $bloc_site->addElement($ul_site_infos);
        
        //--- Bloc d'infos relatives à l'utilisateur ---//
        $bloc_user=new Hgroup();
        $bloc_user->setAttribute('class', 'user-bloc');
        
        $p_infos=new P();
        $p_infos->setAttribute('class', 'log-in');
        
        $p_bonhome=new P();
        $p_bonhome->setAttribute('class', 'log-bh');
        
        if(isset($_SESSION['aviaco']['usr'])){
            
            //--- On recup_re les infos sur cet utilisateur --//
            $usr=EmployeQuery::create()->filterByEmail($_SESSION['aviaco']['usr'])->findOne();
            $p_infos->addElement(new Text($usr->getPrenoom().'('.$usr->getNom().')'));
            
            $ul_infos=new Ul();
            $ul_infos->setAttribute('id', 'usr-bloc');
            $li_inf=new Li(new A(new Text('Modifier mes Infos'), '?action=updte&user='.$usr->getIdEmploye()), '');
            $li_dec=new Li(new A(new Text('Deconnexion'), '?action=dec&user='.$usr->getIdEmploye()), '');
            $ul_infos->addLis(Array($li_inf,$li_dec));
            
            $img=new Img('upload/usr.png');
            $img->setAttribute('id', 'usr-open');
            
            $p_bonhome->addElements(Array($img,$ul_infos));
            $bloc_user->addElements(Array($p_infos,$p_bonhome));
        }
        
        $this->entete->addElements(Array($bloc_site,$bloc_user));
        
    }
    function getEntete() {
        echo $this->entete->toHTML();
    }

}