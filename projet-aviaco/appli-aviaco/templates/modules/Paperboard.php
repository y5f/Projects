<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Paperboard
 *
 * @author Nicolas
 */
class Paperboard extends Template{
    function __construct() {
        parent::__construct(new Div());
        $this->form->setAttribute('class','paperboard-form');
        
        $h2=new H2();
        $h2->addElement(new Text('Paperboard'));
        
        $p_search=new P();
        $in_search=new Input();
        $in_search->setAttribute('type','search');
        $in_search->setAttribute('name','search');
        $in_search->setAttribute('placeholder','Recherche');
        $in_search->setAttribute('onkeyup',"find_board(this.value)");
        $p_search->addElement($in_search);
        
        $tab=new Table(); 
        $tr_title=new Tr();
        $th1=new Th();
        $th1->addElement(new Text('Société'));
        $th2=new Th();
        $th2->addElement(new Text('NOMBRE DE CMD'));
        $th3=new Th();
        $th3->addElement(new Text('Offres'));
        $tr_title->addElements(array($th1,$th2,$th3));
        
        $thead=new Thead();
        $thead->addElement($tr_title);
        
        $tbody=new Tbody();
        $tbody->setAttribute('id', 'list-stock');
        foreach (SocieteQuery::create()->find() as $each){
            //--- On cherche le nombre de commande passé ----
            $cmd=CommandeQuery::create()->filterBySociete($each)->find();
            $nbr_cmd=CommandeQuery::create()->filterBySociete($each)->count();
            
            //--- On verifie si cette commande possède des pièces rentrées ---
            $pce_cmd=0;
            foreach ($cmd as $c) {
                $pce_cmd=CMDPieceQuery::create()->filterByCommande($c)->count();
            }
            
            if($nbr_cmd>0){
                $tr=new Tr();
                $tr->setAttribute('class','init');
                $td1=new Td();$td2=new Td();$td3=new Td();
                $td1->addElement(new A(new Text($each->getSociete()),'?rub=liste&s-rub=fiche-par-societe&soc='.$each->getID()));
                $td2->addElement(new Text($nbr_cmd));
            
                $chbx=new Input();
                $chbx->setAttribute('type', 'checkbox');
                $chbx->setAttribute('value', '');
                if($pce_cmd>0){
                    $chbx->setAttribute('checked', '');
                }
                $td3->addElement($chbx);
                $tr->addElements(array($td1,$td2,$td3));
                $tbody->addElement($tr);
            }
       }
        $tab->addElements(array($thead,$tbody));
        
        $div_tab=new Div();
        $div_tab->addElement($tab);
        //--- Le bouton retour ---
        $b_ret=new Input();
        $b_ret->setAttribute('type', 'button');
        $b_ret->setAttribute('value', 'Retour');
        $p_ret=new P();
        $p_ret->addElement($b_ret);
        
        // récupérer  les fraudes depuis la base 
        $this->form->addElements(array($h2,$p_search,$div_tab,$p_ret));
        
    }
}
