<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchPaperboadForm
 *
 * @author Nicolas
 */
class SearchPaperboadForm extends Template {
    function __construct() {
        parent::__construct(new Div());
        $this->form->setAttribute('class','paper-search');
        
        $h2=new H2();
        $h2->addElement(new Text('Recherche dans Paperboard'));
        
        $p_search=new P();
        $in_search=new Input();
        $in_search->setAttribute('type','search');
        $in_search->setAttribute('name','search');
        $in_search->setAttribute('placeholder','Recherche');
        $in_search->setAttribute('onkeyup',"find_paperboard(this.value)");
        $p_search->addElement($in_search);
        
        $tab=new Table();
       
        
        $tr_title=new Tr();
        $th1=new Th();
        $th1->addElement(new Text('N° PN'));
        $th2=new Th();
        $th2->addElement(new Text('Alt_PN'));
        $th3=new Th();
        $th3->addElement(new Text('Société'));
        
        $tr_title->addElements(array($th1,$th2,$th3));
        
        $thead=new Thead();
        $thead->addElement($tr_title);
        
        $tbody=new Tbody();
        $tbody->setAttribute('id', 'list-stock');
        foreach (COMVendeurQuery::create()->orderByIDVendeur('DESC')->find() as $each){
            $tr=new Tr();
            $tr->setAttribute('class','init');
            $td1=new Td();$td2=new Td();$td3=new Td();
            $td1->addElement(new A(new Text($each->getPiece()->getPN()),'?rub=pn&paper&pce='.$each->getPiece()->getID().'&frs='.$each->getFournisseur()->getID()));
            $td2->addElement(new A(new Text($each->getPiece()->getAltPN()),'?rub=pn&paper&pce='.$each->getPiece()->getID().'&frs='.$each->getFournisseur()->getID()));
            $td3->addElement(new A(new Text($each->getFournisseur()->getSociete()->getSociete()),'?rub=new-part&soc='.$each->getFournisseur()->getSociete()->getID()));
            $tr->addElements(array($td1,$td2,$td3));
           
           $tbody->addElement($tr);
       }
        $tab->addElements(array($thead,$tbody));
        
        // récupérer  les fraudes depuis la base 
        $this->form->addElements(array($h2,$p_search,$tab));    
    }
}
