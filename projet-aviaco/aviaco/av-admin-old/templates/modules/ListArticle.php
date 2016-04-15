<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ListArticle
 *
 * @author StrawHat
 */
class ListArticle{

    private $div;
    function __construct() {
       
        $this->div=new Div();
        $this->div->setAttribute('id','art-list');
        $h_art=new H1();
        $h_art->addElement(New Text('Liste des articles'));
        $tab=new Table();
        $tab->setAttribute('align', 'center');
        //$tab->setAttribute('border','1');
        
        $thead=new Thead();
        $tr_head=new Tr();
        $td_titre=new Th();
        $td_titre->addElement(New Text('Titre'));
        $td_op=new Th();
        $td_op->addElement(New Text('Opération'));
        $tr_head->addElements(Array($td_titre,$td_op));
        $thead->addElement($tr_head);
        
        $tbody=new Tbody();
        $arts=ArticleQuery::create()->find();
        foreach ($arts as $art){
            $tr=new Tr();
            $td1=new Td();
            $td1->setAttribute('class','text-titre');
            $td1->addElement(New text($art->getTitre()));
            $td2=new Td();
            $but_edit=new Input();
            $but_edit->setAttribute('type', 'button');
            //$but_edit->setAttribute('id','art-edit');
            $but_edit->setAttribute('class','edit '.$art->getNumart().' art-edit');
            $but_sup=new Input();
            $but_sup->setAttribute('type', 'button');
            //$but_sup->setAttribute('id', 'art-del');
            $but_sup->setAttribute('class','sup '.$art->getNumart().' art-del');
            $but_pub=new Input();
            $but_pub->setAttribute('type', 'button');

            $td2->addElements(Array(new A($but_edit,'?rub=article&edit='.$art->getNumart()),$but_sup));
            $tr->addElements(Array($td1,$td2));
            $tbody->addElement($tr); 
        }
            
        $tab->addElements(Array($thead,$tbody));
        $this->div->addElements(Array($h_art,$tab));
    }

    function getForm(){
        return $this->div;
    }
    
}
