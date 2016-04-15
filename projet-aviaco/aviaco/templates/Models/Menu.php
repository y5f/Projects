<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Menu {

    private $menu;
    private $host;
    private $top_menu;
    
    function __construct() {
        
        //--- On calcule l'url ---
        $this->menu=new Ul();
        $this->host='?url=';
        
        $this->top_menu=new Hgroup();
        $this->top_menu->setAttribute('class', 'sous-bloc');
        $details_menu=new Div();
        $details_menu->setAttribute('class', 'menu-details');
        $this->top_menu->addElement($details_menu);
        
        $mes_menus=MenusQuery::create()->filterByNiveau(1)->orderByOrdre('ASC')->find();
        $cmpt=0;
        foreach ($mes_menus as $menu) {
            $cmpt++;
            $m=new Div();
            $m->setAttribute('class', 'm-bloc');
            $m->setAttribute('name', $menu->getURL());
            $m->addElement(new Text($menu->getMenu()));
            $m_a=new A($m, '?url='.$menu->getURL().'&'.$menu->getCommentaire());
            //--- Pour le menu du pied de page ---//
            $li=new Li(new Text($menu->getMenu()), $menu->getURL());
            //--- Si ce menu est lié à un sous-menu, on le parcourt ---//

            if($menu->getSousmenus()->count()>0){
                $li->addElement($this->getSoumenu($menu));
            }
            //print_r($li->toHTML());
            if($menu->getOrdre()==1 || $menu->getOrdre()==2 || $menu->getOrdre()==5){
                $this->top_menu->addElement($m_a);
                //$this->menu->addElement($m_a);
            }else{
                $this->top_menu->addElement($m);
            } 
            if($menu->getOrdre()!==1){
                $this->menu->addElement($li);
            }
        }
        
    }
    function getMenu(){
        return $this->menu;
    }
    function setAttribute($key,$value){
        $this->menu->setAttribute($key, $value);
    }
    function getTop_menu() {
        return $this->top_menu;
    }
    function castURL($url) {
        $temps=strtolower($url);
        $tempss=preg_replace('#\s#', '-', $temps);
        //$texte = strtr($tempss,'@ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','aAAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        return $tempss;
    }
    function getSoumenu(Menus $menu) {
        //echo $menu;
        $array=new Ul();
        foreach ($menu->getSousmenus() as $s_m) {
            //$s_m=new Sousmenu();
            $li=new Li(new Text($s_m->getSousmenu()), $s_m->getSousmenu());
            
            //--- On verifie si le sous lien possède des enfants --//
            $men=MenusQuery::create()->filterByMenu($s_m->getSousmenu())->find();
            
            //--- Calcul du lien -----//
            $url='?url='.$s_m->getURL().'&'.$s_m->getCommentaire();
            foreach ($men as $m) {
                if($m->getNiveau()>$menu->getNiveau()){ 
                    $li->addElement($this->getSoumenu($m));
                }
            }
            $li_a=new A($li, $url);
            $array->addElement($li_a);
            
        }
        return $array;
    }
}
