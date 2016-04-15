<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlainteForm
 *
 * @author Nicolas
 */
class PlainteForm extends Template{
    function __construct() {
        parent::__construct(new Div);
        
        $this->form->setAttribute('id','plainte-form');
        
        $hg=new Hgroup();
        
        //--- Colonne pour choix de la société --
        $choix_soc=new Fieldset('Choisir la société plaignante');
        $tab_soc=new Table();
        $tb=new Tbody();
        $div_tab=new Div();
        //---- On parcour tous les partenaire ------
        foreach (PartenaireQuery::create()->orderByPartenaire('ASC')->find() as $part) {
            $tr_b=new Tr();
            
            $radio_bout=new Input();
            $radio_bout->setAttribute('type', 'radio');
            $radio_bout->setAttribute('value', 'part^'.$part->getID());
            $radio_bout->setAttribute('name', 'part');
            $radio_bout->setAttribute('class', 'p-plainte');
            
            $em=new Em();
            $em->addElement(new Text($part->getPartenaire()));
            
            $td=new Td();
            $td->addElements(Array($radio_bout,$em));
            $tr_b->addElement($td);
            $tb->addElement($tr_b);
        }
        
        //--- une plainte peut etre deposée par une société entant que telle --
        foreach (SocieteQuery::create()->orderBySociete('ASC')->find() as $soc) {
            $tr_b=new Tr();
            
            $radio_bout=new Input();
            $radio_bout->setAttribute('type', 'radio');
            $radio_bout->setAttribute('value', 'soc^'.$soc->getID());
            $radio_bout->setAttribute('name', 'part');
            $radio_bout->setAttribute('class', 'p-plainte');
            
            $em=new Em();
            $em->addElement(new Text($soc->getSociete()));
            
            $td=new Td();
            $td->addElements(Array($radio_bout,$em));
            $tr_b->addElement($td);
            $tb->addElement($tr_b);
        }
        
        $tab_soc->addElement($tb);
        $div_tab->addElement($tab_soc);
        $choix_soc->addElement($div_tab);
        
        //--- Colonne permettant de saisir le nom du plaigant --
        $bloc_plain=new Fieldset('Entrer un plaignat');
        $p_plaint=new P();
        $l_plaint=new Label('');
        $l_plaint->addElement(new Text('Nom du plaignant :'));
        $inp_plaint=new Input();
        $inp_plaint->setAttribute('type', 'text');
        $inp_plaint->setAttribute('id', 'plaignant');
        $p_plaint->addElements(Array($l_plaint,$inp_plaint));
        
        $but_add=new Input();
        $but_add->setAttribute('type', 'submit');
        $but_add->setAttribute('id', 'add-fraude');
        $but_add->setAttribute('value', 'Ajouter');
        
        $bloc_plain->addElements(Array($p_plaint,$but_add));
        
        $b_close=new Em();
        $b_close->addElement(new A(new Text('X'),''));
        
        $hg->addElements(Array($b_close,$choix_soc,$bloc_plain));
        $this->form->addElement($hg);
    }
}
