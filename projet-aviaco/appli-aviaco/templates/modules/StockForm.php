<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StockForm
 *
 * @author Nicolas
 */
class StockForm extends Template{
    function __construct() {
         parent::__construct(new Div());
        $this->form->setAttribute('class','fraude');
        
        $h2=new H2();
        $h2->addElement(new Text('Liste stock'));
        
        $p_search=new P();
        $in_search=new Input();
        $in_search->setAttribute('type','search');
        $in_search->setAttribute('name','search');
        $in_search->setAttribute('placeholder','Recherche');
        $in_search->setAttribute('onkeyup',"find_stock(this.value)");
        $p_search->addElement($in_search);
        
        $tab=new Table();
       
        
        $tr_title=new Tr();
        $th1=new Th();
        $th1->addElement(new Text('N°série'));
        $th2=new Th();
        $th2->addElement(new Text('PN'));
        $th3=new Th();
        $th3->addElement(new Text('Alt PN'));
        $th4=new Th();
        $th4->addElement(new Text('Propriétaire'));
        $th5=new Th();
        $th5->addElement(new Text('MAJ'));
        $th6=new Th();
        $th6->addElement(new Text('Fabricant'));
        $th7=new Th();
        $th7->addElement(new Text('Appareil'));
        
        $tr_title->addElements(array($th1,$th2,$th3,$th4,$th5,$th6,$th7));
        
        $thead=new Thead();
        $thead->addElement($tr_title);
        
        $tbody=new Tbody();
        $tbody->setAttribute('id', 'list-stock');
        foreach (FournisseurQuery::create()->orderByDTESave('DESC')->find() as $each){
            //-- On recupère la relation piece-societe --
            //$piece_soc=FournisseurQuery::create()->filterByPiece($each->getPiece())->findOne();
            //if(!$piece_soc){
              //  $each->delete();
                //continue;
            //}
            //--- On recupère aussi la relation piece-appareil --
            $piece_app=PieceAppQuery::create()->filterByPiece($each->getPiece())->findOne();
            if(!$piece_app){
                $app='non spécifié';
                $mark='non spécifié';
            }else{
                $app=$piece_app->getAppareil()->getNomApp();
                $mark=$piece_app->getAppareil()->getMarque_PK();
            }
            $tr=new Tr();
            $tr->setAttribute('class','init');
            $td1=new Td();$td2=new Td();$td3=new Td();$td4=new Td();$td5=new Td();$td6=new Td();$td7=new Td();
            $td1->addElement(new Text($each->getPiece()->getReference()));
            $td2->addElement(new Text($each->getPiece()->getPN()));
            $td3->addElement(new Text($each->getPiece()->getAltPN()));
            $td4->addElement(new Text($each->getSociete()->getSociete()));
            $td5->addElement(new Text($each->getDTESave('d/m/y')));
            $td6->addElement(new Text($mark));
            $td7->addElement(new Text($app));
            $tr->addElements(array($td1,$td2,$td3,$td4,$td5,$td6,$td7));
           
           $tbody->addElement($tr);
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
